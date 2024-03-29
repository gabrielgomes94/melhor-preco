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
    'mercado_livre' => [
        'free_freight_discount' => 79,
        'free_freight_table_1' => [
            [
                'interval' => [0, 0.499],
                'value' => 32.9,
            ],
            [
                'interval' => [0.5, 0.999],
                'value' => 35.9,
            ],
            [
                'interval' => [1, 1.999],
                'value' => 36.9,
            ],
            [
                'interval' => [2, 4.999],
                'value' => 45.9,
            ],
            [
                'interval' => [5, 8.999],
                'value' => 67.9,
            ],
            [
                'interval' => [9, 12.999],
                'value' => 106.9,
            ],
            [
                'interval' => [13, 16.999],
                'value' => 118.9,
            ],
            [
                'interval' => [17, 22.999],
                'value' => 138.9,
            ],
            [
                'interval' => [23, 28.999],
                'value' => 159.9,
            ],
            [
                'interval' => [29, 999999999999],
                'value' => 181.9,
            ],
        ],
        'free_freight_table_2' => [
            [
                'interval' => [0, 0.499],
                'value' => 16.45,
            ],
            [
                'interval' => [0.5, 0.999],
                'value' => 17.95,
            ],
            [
                'interval' => [1, 1.999],
                'value' => 18.45,
            ],
            [
                'interval' => [2, 4.999],
                'value' => 22.95,
            ],
            [
                'interval' => [5, 8.999],
                'value' => 33.95,
            ],
            [
                'interval' => [9, 12.999],
                'value' => 53.45,
            ],
            [
                'interval' => [13, 16.999],
                'value' => 59.45,
            ],
            [
                'interval' => [17, 22.999],
                'value' => 69.45,
            ],
            [
                'interval' => [23, 28.999],
                'value' => 79.95,
            ],
            [
                'interval' => [29, 999999999999],
                'value' => 90.95,
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
