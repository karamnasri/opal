<?php

namespace App\ValueObjects;

use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class MoneySynthesizer extends Synth
{
    public static $key = 'money';

    public static function match($target)
    {
        return $target instanceof Money;
    }

    public function dehydrate($target)
    {
        return [$target->raw(), []];
    }

    public function hydrate($value)
    {
        return new Money($value);
    }
}
