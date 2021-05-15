<?php


return [
    'b2w' => [
        'seller_index' => [
            [
                'interval' => [0, 119],
                'discount_percentage' => 0,
            ],
            [
                'interval' => [120, 149],
                'discount_percentage' => 40,
            ],
            [
                'interval' => [150, 999999999999],
                'discount_percentage' => 50,
            ],
        ],
        'subsidy_freight' => [
            'value' => 12.90,
        ],
        'free_freight_table' => [
            [
                'interval' => [0, 0.499],
                'value' => 18.59,
            ],
            [
                'interval' => [0.5, 0.999],
                'value' => 20.39,
            ],
            [
                'interval' => [1, 1.999],
                'value' => 20.99,
            ],
            [
                'interval' => [2, 4.999],
                'value' => 26.39,
            ],
            [
                'interval' => [5, 8.999],
                'value' => 38.39,
            ],
            [
                'interval' => [9, 12.999],
                'value' => 59.99,
            ],
            [
                'interval' => [13, 16.999],
                'value' => 66.59,
            ],
            [
                'interval' => [17, 22.999],
                'value' => 77.99,
            ],
            [
                'interval' => [23, 28.999],
                'value' => 89.99,
            ],
            [
                'interval' => [29, 999999999999],
                'value' => 101.99,
            ],
        ],
    ]
];