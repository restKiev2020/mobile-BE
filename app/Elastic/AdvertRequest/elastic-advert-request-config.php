<?php

return [
    'mapping' => [
        'properties' => [
            'price_usd' => [
                'type' => 'double'
            ],
            'price_usd_min' => [

            ],
            'price_usd_max' => [

            ],
            'price_uah' => [
                'type' => 'double'
            ],
            'price_uah_min' => [
                'type' => 'double'
            ],
            'price_uah_max' => [
                'type' => 'double'
            ],
            'price_per_ms_usd' => [
                'type' => 'double'
            ],
            'price_per_ms_usd_min' => [
                'type' => 'double'
            ],
            'price_per_ms_usd_max' => [
                'type' => 'double'
            ],
            'price_per_ms_uah' => [
                'type' => 'double'
            ],
            'price_per_ms_uah_min' => [
                'type' => 'double'
            ],
            'price_per_ms_uah_max' => [
                'type' => 'double'
            ],
            'user_id' => [
                'type' => 'keyword'
            ],
            'street' => [
                'type' => 'keyword',
            ],
            'building' => [
                'type' => 'text',
                'analyzer' => 'index_analyzer',
                'search_analyzer' => 'search_analyzer',
            ],
            'city' => [
                'type' => 'keyword',
            ],
            'district' => [
                'type' => 'keyword',
            ],
            'microdistrict' => [
                'type' => 'keyword',
            ],
            'total_area' => [
                'type' => 'double'
            ],
            'total_area_min' => [
                'type' => 'double'
            ],
            'total_area_max' => [
                'type' => 'double'
            ],
            'has_repair' => [
                'type' => 'boolean'
            ],
            'title' => [
                'type' => 'text',
                'analyzer' => 'index_analyzer',
                'search_analyzer' => 'search_analyzer',
            ],
            'description' => [
                'type' => 'text',
                'analyzer' => 'index_analyzer',
                'search_analyzer' => 'search_analyzer',
            ],
            'notes' => [
                'type' => 'text'
            ],
            'property_type' => [
                'type' => 'keyword'
            ],
            'type' => [
                'type' => 'keyword'
            ],
            'storeys' => [
                'type' => 'byte'
            ],
            'floor' => [
                'type' => 'byte'
            ],
            'rooms' => [
                'type' => 'byte'
            ],
            'wall_material' => [
                'type' => 'text',
                'analyzer' => 'index_analyzer',
                'search_analyzer' => 'search_analyzer',
            ],
            'living_area' => [
                'type' => 'double'
            ],
            'living_area_min' => [
                'type' => 'double'
            ],
            'living_area_max' => [
                'type' => 'double'
            ],
            'kitchen_area' => [
                'type' => 'double'
            ],
            'kitchen_area_min' => [
                'type' => 'double'
            ],
            'kitchen_area_max' => [
                'type' => 'double'
            ],
            'construction_type' => [
                'type' => 'keyword'
            ],
            'apartment_number' => [
                'type' => 'short'
            ],
            'entrance' => [
                'type' => 'keyword'
            ],
            'building_type' => [
                'type' => 'keyword'
            ],
            'rooms_layout' => [
                'type' => 'keyword'
            ],
            'bedrooms' => [
                'type' => 'byte'
            ],
            'condition' => [
                'type' => 'keyword'
            ],
            'bathroom' => [
                'type' => 'keyword'
            ],
            'heating' => [
                'type' => 'keyword'
            ],
            'ceiling_height' => [
                'type' => 'keyword'
            ],
            'house_letter' => [
                'type' => 'keyword'
            ],
            'subway' => [
                'type' => 'keyword'
            ],
            'region' => [
                'type' => 'keyword'
            ],
            'housing_complex_title' => [
                'type' => 'keyword'
            ],
            'flat_number' => [
                'type' => 'short'
            ],
            'first_rent' => [
                'type' => 'boolean'
            ],
            'registration_possibility' => [
                'type' => 'boolean'
            ],
            'cashless_payment' => [
                'type' => 'boolean'
            ],
            'restrictions' => [
                'type' => 'text',
                'fielddata' => true,
            ],
            'yard_area' => [
                'type' => 'double'
            ],
            'yard_area_min' => [
                'type' => 'double'
            ],
            'yard_area_max' => [
                'type' => 'double'
            ],
            'communications' => [
                'type' => 'text',
                'fielddata' => true,
            ],
            'inside_of_cottage' => [
                'type' => 'boolean'
            ],
            'access_to_water' => [
                'type' => 'boolean'
            ],
            'additional_info' => [
                'type' => 'text',
                'analyzer' => 'index_analyzer',
                'search_analyzer' => 'search_analyzer',
            ],
            'house_access_floor' => [
                'type' => 'keyword'
            ],
            'seasonal_rent' => [
                'type' => 'boolean'
            ],
            'area_access_floor' => [
                'type'=> 'keyword'
            ],
            'feeValue' => [
                'type' => 'float'
            ],
            'sppValue' => [
                'type' => 'float'
            ],
            'keywords' => [
                'type' => 'text',
                'analyzer' => 'index_analyzer',
                'search_analyzer' => 'search_analyzer',
            ]
        ]
    ]
];
