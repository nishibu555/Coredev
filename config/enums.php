<?php

return [
    'genders' => ['male', 'female'],
    'age_disparities' => ['kid', 'baby', 'adult'],
    'connection_statuses' => ['requested', 'connected', 'ignored', 'declined'],
    'media_types' => ['image', 'audio', 'video', 'document'],
    'address_types' => ['current', 'previous'],
    'contact_types' => ['primary', 'secondary', 'emergency'],
    'gift_plans_statuses' => [
        'planning' => 'secondary',
        'planned' => 'primary',
        'accepted' => 'success',
        'sent' => 'secondary'
    ],
    'currencies' => ['GBP', 'USD', 'BDT'],

    'conversation_member_status' => [
        'active',
        'block'
    ],

    'chat_message_types' => [
        'message',
        'meta'
    ],

    'religions' => [
        'christianity',
        'islam',
        'hinduism',
        'buddhism',
        'others'
    ],

    'marital_statuses' => [
        'married',
        'single',
    ],

    'gift_idea_levels' => [
        'let_receiver_choose',
        'need_suggestion',
        'have_some_ideas',
        'know_exactly',
    ],

    'product_sorting_options' => [
        [
            'key' => 'Best Match',
            'value' => 'best_match',
        ],
        [
            'key' => 'Price: Low to High',
            'value' => 'price_low_to_high',
        ],
        [
            'key' => 'Price: High to Low',
            'value' => 'price_high_to_low',
        ],
        [
            'key' => 'Newest Arrival',
            'value' => 'newest_arrival',
        ],
        [
            'key' => 'Popularity',
            'value' => 'popular',
        ],
        [
            'key' => 'Discount %: Low to High',
            'value' => 'discount_percent_low_to_high',
        ],
        [
            'key' => 'Discount %: High to Low',
            'value' => 'discount_percent_high_to_low',
        ],
        [
            'key' => 'Avg. Customer Review',
            'value' => 'rating',
        ]
    ],

    'event_visibilities' => ['private', 'network', 'public'],
    'pagination' => 15,
    'user_status_colors' => ['danger', 'success'],

    'reaction_types' => ['smile', 'love', 'surprise', 'wow', 'worried', 'crying', 'angry',],

    'privacy_types' =>
        [
            [
                'key' => 'Private',
                'value' => 'private',
            ],
            [
                'key' => 'Network',
                'value' => 'network',
            ],
            [
                'key' => 'Public',
                'value' => 'public',
            ],
        ]
];
