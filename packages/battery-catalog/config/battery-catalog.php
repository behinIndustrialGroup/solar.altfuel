<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Battery Types
    |--------------------------------------------------------------------------
    |
    | Available battery types for energy storage systems
    |
    */
    'battery_types' => [
        'LiFePO4',
        'Lithium-ion',
        'Lead Acid',
        'Gel',
        'AGM',
        'NMC',
    ],

    /*
    |--------------------------------------------------------------------------
    | Battery Standards
    |--------------------------------------------------------------------------
    |
    | List of international standards for battery certification
    |
    */
    'standards' => [
        'IEC 62619',
        'IEC 62620',
        'IEC 62133',
        'UN38.3',
        'CE',
        'UL1973',
        'IEC 63056',
    ],

    /*
    |--------------------------------------------------------------------------
    | Approved Laboratories
    |--------------------------------------------------------------------------
    |
    | List of approved laboratories for battery certification
    |
    */
    'approved_labs' => [
        'پژوهشگاه نیرو',
        'EPILL',
    ],

    /*
    |--------------------------------------------------------------------------
    | Communication Protocols
    |--------------------------------------------------------------------------
    |
    | Available communication protocols for batteries
    |
    */
    'communication_protocols' => [
        'CAN',
        'RS485',
        'Modbus',
        'Ethernet',
        'WiFi',
        'Bluetooth',
    ],

    /*
    |--------------------------------------------------------------------------
    | IP Rating Options
    |--------------------------------------------------------------------------
    |
    | Available IP protection ratings
    |
    */
    'ip_ratings' => [
        'IP20',
        'IP54',
        'IP55',
        'IP65',
        'IP66',
    ],
];
