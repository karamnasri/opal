<?php

namespace App\Filament\Resources;

use App\Enums\PrintTypeEnum;
use App\Filament\Resources\DesignResource\Pages;
use App\Filament\Resources\DesignResource\RelationManagers;
use App\Models\Design;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DesignResource extends Resource
{
    protected static ?string $model = Design::class;

    protected static ?int $navigationSort  = 5;
    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static ?string $navigationLabel = 'Designs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->nullable(),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->step(0.01)
                    ->prefix('$')
                    ->afterStateHydrated(function ($component, $state) {
                        $component->state($state?->inDollars());
                    })
                    ->dehydrateStateUsing(fn($state) => (int) ($state * 100)),

                TextInput::make('discount_percentage')
                    ->label('Discount %')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(99)
                    ->default(0),

                Select::make('print_type')
                    ->required()
                    ->options(PrintTypeEnum::class)
                    ->native(false),

                TagsInput::make('color')
                    ->label('Colors')
                    ->placeholder('Add hex codes like #FF0000, #00FF00...')
                    ->suggestions(['#FF0000', '#00FF00', '#0000FF', '#000000', '#FFFFFF'])
                    ->default([]),

                Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),

                FileUpload::make('file_path')
                    ->label('Design File')
                    ->required()
                    ->directory('designs/files')
                    ->disk('designs')
                    ->downloadable()
                    ->required(fn(string $context): bool => $context === 'create')
                    ->visible(fn(string $context): bool => $context === 'create'),

                FileUpload::make('image_path')
                    ->label('Preview Image')
                    ->image()
                    ->directory('designs/images')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),

                TextColumn::make('original_price')
                    ->label('Original Price')
                    ->prefix('$')
                    ->sortable(),

                TextColumn::make('final_price')
                    ->label('Final Price')
                    ->prefix('$')
                    ->sortable(query: function (Builder $query, string $direction) {
                        $query->orderBy('price', $direction)
                            ->orderBy('discount_percentage', $direction === 'asc' ? 'desc' : 'asc');
                    }),

                BadgeColumn::make('discount_percentage')
                    ->label('Discount')
                    ->color(fn($state) => $state > 0 ? 'success' : 'secondary')
                    ->formatStateUsing(fn($state) => $state > 0 ? $state . '%' : 'None'),

                TextColumn::make('likers_count')
                    ->label('Likes')
                    ->sortable(),

                TextColumn::make('purchases_count')
                    ->label('Purchases')
                    ->sortable(),

                TextColumn::make('categories.name')
                    ->badge()
                    ->separator(','),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->withCount(['likers', 'purchases']);
            })
            ->defaultSort(
                column: 'id',
                direction: 'desc'
            )
            ->filters([
                Tables\Filters\SelectFilter::make('print_type')
                    ->options(PrintTypeEnum::class),

                Tables\Filters\TernaryFilter::make('is_free')
                    ->label('Free/Paid')
                    ->trueLabel('Free Designs')
                    ->falseLabel('Paid Designs')
                    ->queries(
                        true: fn($query) => $query->where('price', 0),
                        false: fn($query) => $query->where('price', '>', 0),
                    ),

                Tables\Filters\MultiSelectFilter::make('categories')
                    ->relationship('categories', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->withCount(['likers', 'purchases']);
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesigns::route('/'),
            'create' => Pages\CreateDesign::route('/create'),
            'edit' => Pages\EditDesign::route('/{record}/edit'),
        ];
    }
}
