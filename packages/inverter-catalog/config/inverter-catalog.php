<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Inverter Standards
    |--------------------------------------------------------------------------
    |
    | List of international standards for inverter certification
    |
    */
    'standards' => [
        'IEC 62109',
        'IEC 61727',
        'IEC 62116',
        'IEC 61000',
        'CE',
        'VDE-AR-N 4105',
        'G99',
        'G98',
    ],

    /*
    |--------------------------------------------------------------------------
    | Approved Laboratories
    |--------------------------------------------------------------------------
    |
    | List of approved laboratories for inverter certification
    |
    */
    'approved_labs' => [
        'پژوهشگاه نیرو',
        'EPILL',
    ],

    /*
    |--------------------------------------------------------------------------
    | Inverter Types
    |--------------------------------------------------------------------------
    |
    | Available inverter types
    |
    */
    'inverter_types' => [
        'On-Grid',
        'Off-Grid',
        'Hybrid',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cooling Types
    |--------------------------------------------------------------------------
    |
    | Available cooling methods for inverters
    |
    */
    'cooling_types' => [
        'Natural',
        'Fan',
        'Liquid',
    ],

    /*
    |--------------------------------------------------------------------------
    | Communication Protocols
    |--------------------------------------------------------------------------
    |
    | Available communication protocols
    |
    */
    'communication_protocols' => [
        'WiFi',
        'CAN',
        'RS485',
        'Ethernet',
        'Bluetooth',
        'Modbus',
    ],
];
