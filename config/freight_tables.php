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
    ],
    'olist' => [
        'customer_freight_value' => 5.0,
        'free_freight_discount' => 40.0,
        'free_freight_table' => [
            [
                'interval' => [0, 0.5],
                'value' => 30.99,
            ],
            [
                'interval' => [0.501, 1],
                'value' => 33.99,
            ],
            [
                'interval' => [1.001, 2],
                'value' => 34.99,
            ],
            [
                'interval' => [2.001, 5],
                'value' => 43.99,
            ],
            [
                'interval' => [5.001, 9],
                'value' => 63.99,
            ],
            [
                'interval' => [9.001, 13],
                'value' => 99.99,
            ],
            [
                'interval' => [13.001, 17],
                'value' => 110.99,
            ],
            [
                'interval' => [17.001, 23],
                'value' => 129.99,
            ],
            [
                'interval' => [23.001, 29],
                'value' => 149.99,
            ],
            [
                'interval' => [29.001, 999999999999],
                'value' => 169.99,
            ],
        ],
    ],
];
