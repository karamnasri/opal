<?php

return [
    'User' => [
        'table' => 'users',
        'dto' => [
            'fields' => [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ],
        ],
        'resource' => [
            'fields' => [
                'id',
                'name',
                'email',
            ],
        ],
    ],

    'Design' => [
        'table' => 'designs',
        'dto' => [
            'fields' => [
                'name' => 'required|string|unique:designs,name',
                'description' => 'nullable|string',
                'price' => 'nullable|numeric',
                'file' => 'required|file|mimes:jpg,png,pdf,psd,ai,eps',
                'color' => 'nullable|json',
                'category_id' => 'nullable|exists:categories,id',
            ],
        ],
        'resource' => [
            'fields' => [
                'id',
                'name',
                'description',
                'price',
                'file_path',
                'created_at',
            ],
        ],
    ],

    'Material' => [
        'table' => 'materials',
        'dto' => [
            'fields' => [
                'name' => 'required|string',
            ],
        ],
        'resource' => [
            'fields' => [
                'id',
                'name',
            ],
        ],
    ],

    'Order' => [
        'table' => 'orders',
        'dto' => [
            'fields' => [
                'user_id' => 'required|exists:users,id',
                'design_id' => 'required|exists:designs,id',
                'quantity' => 'required|integer',
                'status' => 'required|string|in:pending,processed,shipped,delivered',
            ],
        ],
        'resource' => [
            'fields' => [
                'id',
                'user_id',
                'design_id',
                'quantity',
                'status',
                'created_at',
            ],
        ],
    ],

    'Category' => [
        'table' => 'categories',
        'dto' => [
            'fields' => [
                'name' => 'required|string|unique:categories,name',
                'description' => 'nullable|string',
            ],
        ],
        'resource' => [
            'fields' => [
                'id',
                'name',
                'description',
            ],
        ],
    ],

    'Tag' => [
        'table' => 'tags',
        'dto' => [
            'fields' => [
                'name' => 'required|string|unique:tags,name',
            ],
        ],
        'resource' => [
            'fields' => [
                'id',
                'name',
            ],
        ],
    ],
];
