<?php

return [

    // GST rate applied to the final payment amount
    'gst_rate' => env('GST_RATE', 18),

    // India
    'IN'       => [
        'percentage' => 100,
        'currency'   => 'INR', // Indian Rupee
    ],

    // United States
    'US'       => [
        'percentage' => 2,
        'currency'   => 'USD', // US Dollar
    ],

    // United Kingdom
    'GB'       => [
        'percentage' => 2,
        'currency'   => 'GBP', // British Pound
    ],

    // United Arab Emirates
    'AE'       => [
        'percentage' => 3,
        'currency'   => 'AED', // UAE Dirham
    ],

    // Canada
    'CA'       => [
        'percentage' => 2,
        'currency'   => 'CAD', // Canadian Dollar
    ],

    // Australia
    'AU'       => [
        'percentage' => 3,
        'currency'   => 'AUD', // Australian Dollar
    ],

    // Germany
    'DE'       => [
        'percentage' => 2,
        'currency'   => 'EUR', // Euro
    ],

    // France
    'FR'       => [
        'percentage' => 2,
        'currency'   => 'EUR', // Euro
    ],

    // Italy
    'IT'       => [
        'percentage' => 2,
        'currency'   => 'EUR', // Euro
    ],

    // Spain
    'ES'       => [
        'percentage' => 2,
        'currency'   => 'EUR', // Euro
    ],

    // Netherlands
    'NL'       => [
        'percentage' => 2,
        'currency'   => 'EUR', // Euro
    ],

    // Singapore
    'SG'       => [
        'percentage' => 3,
        'currency'   => 'SGD', // Singapore Dollar
    ],

    // Saudi Arabia
    'SA'       => [
        'percentage' => 3,
        'currency'   => 'SAR', // Saudi Riyal
    ],

    // Qatar
    'QA'       => [
        'percentage' => 3,
        'currency'   => 'QAR', // Qatari Riyal
    ],

    // Kuwait
    'KW'       => [
        'percentage' => 3,
        'currency'   => 'KWD', // Kuwaiti Dinar
    ],

    // Bahrain
    'BH'       => [
        'percentage' => 3,
        'currency'   => 'BHD', // Bahraini Dinar
    ],

    // Japan
    'JP'       => [
        'percentage' => 3,
        'currency'   => 'JPY', // Japanese Yen
    ],

    // New Zealand
    'NZ'       => [
        'percentage' => 3,
        'currency'   => 'NZD', // New Zealand Dollar
    ],

    // Switzerland
    'CH'       => [
        'percentage' => 2,
        'currency'   => 'CHF', // Swiss Franc
    ],

    // South Africa
    'ZA'       => [
        'percentage' => 3,
        'currency'   => 'ZAR', // South African Rand
    ],

    // Malaysia
    'MY'       => [
        'percentage' => 3,
        'currency'   => 'MYR', // Malaysian Ringgit
    ],

    // Indonesia
    'ID'       => [
        'percentage' => 3,
        'currency'   => 'IDR', // Indonesian Rupiah
    ],

    // Thailand
    'TH'       => [
        'percentage' => 3,
        'currency'   => 'THB', // Thai Baht
    ],

    // Philippines
    'PH'       => [
        'percentage' => 3,
        'currency'   => 'PHP', // Philippine Peso
    ],

    // Bangladesh
    'BD'       => [
        'percentage' => 3,
        'currency'   => 'BDT', // Bangladeshi Taka
    ],

    // Pakistan
    'PK'       => [
        'percentage' => 3,
        'currency'   => 'PKR', // Pakistani Rupee
    ],

    // Sri Lanka
    'LK'       => [
        'percentage' => 3,
        'currency'   => 'LKR', // Sri Lankan Rupee
    ],

    // Nepal
    'NP'       => [
        'percentage' => 3,
        'currency'   => 'NPR', // Nepalese Rupee
    ],

    // Any country not listed above
    'DEFAULT'  => [
        'percentage' => 2,
        'currency'   => 'USD', // US Dollar
    ],

];
