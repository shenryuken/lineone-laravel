<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            // ASIA
            [
                'code' => 'MYS',
                'code_alpha2' => 'MY',
                'name' => 'Malaysia',
                'currency_code' => 'MYR',
                'currency_name' => 'Malaysian Ringgit',
                'currency_symbol' => 'RM',
                'phone_code' => '60',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Kuala Lumpur',
                    'language' => 'Malay',
                    'timezone' => 'UTC+8',
                ]
            ],
            [
                'code' => 'SGP',
                'code_alpha2' => 'SG',
                'name' => 'Singapore',
                'currency_code' => 'SGD',
                'currency_name' => 'Singapore Dollar',
                'currency_symbol' => 'S$',
                'phone_code' => '65',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Singapore',
                    'language' => 'English, Malay, Mandarin, Tamil',
                    'timezone' => 'UTC+8',
                ]
            ],
            [
                'code' => 'IDN',
                'code_alpha2' => 'ID',
                'name' => 'Indonesia',
                'currency_code' => 'IDR',
                'currency_name' => 'Indonesian Rupiah',
                'currency_symbol' => 'Rp',
                'phone_code' => '62',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Jakarta',
                    'language' => 'Indonesian',
                    'timezone' => 'UTC+7',
                ]
            ],
            [
                'code' => 'THA',
                'code_alpha2' => 'TH',
                'name' => 'Thailand',
                'currency_code' => 'THB',
                'currency_name' => 'Thai Baht',
                'currency_symbol' => '฿',
                'phone_code' => '66',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Bangkok',
                    'language' => 'Thai',
                    'timezone' => 'UTC+7',
                ]
            ],
            [
                'code' => 'PHL',
                'code_alpha2' => 'PH',
                'name' => 'Philippines',
                'currency_code' => 'PHP',
                'currency_name' => 'Philippine Peso',
                'currency_symbol' => '₱',
                'phone_code' => '63',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Manila',
                    'language' => 'Filipino, English',
                    'timezone' => 'UTC+8',
                ]
            ],
            [
                'code' => 'VNM',
                'code_alpha2' => 'VN',
                'name' => 'Vietnam',
                'currency_code' => 'VND',
                'currency_name' => 'Vietnamese Dong',
                'currency_symbol' => '₫',
                'phone_code' => '84',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Hanoi',
                    'language' => 'Vietnamese',
                    'timezone' => 'UTC+7',
                ]
            ],
            [
                'code' => 'JPN',
                'code_alpha2' => 'JP',
                'name' => 'Japan',
                'currency_code' => 'JPY',
                'currency_name' => 'Japanese Yen',
                'currency_symbol' => '¥',
                'phone_code' => '81',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Tokyo',
                    'language' => 'Japanese',
                    'timezone' => 'UTC+9',
                ]
            ],
            [
                'code' => 'KOR',
                'code_alpha2' => 'KR',
                'name' => 'South Korea',
                'currency_code' => 'KRW',
                'currency_name' => 'South Korean Won',
                'currency_symbol' => '₩',
                'phone_code' => '82',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Seoul',
                    'language' => 'Korean',
                    'timezone' => 'UTC+9',
                ]
            ],
            [
                'code' => 'CHN',
                'code_alpha2' => 'CN',
                'name' => 'China',
                'currency_code' => 'CNY',
                'currency_name' => 'Chinese Yuan',
                'currency_symbol' => '¥',
                'phone_code' => '86',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Beijing',
                    'language' => 'Mandarin',
                    'timezone' => 'UTC+8',
                ]
            ],
            [
                'code' => 'HKG',
                'code_alpha2' => 'HK',
                'name' => 'Hong Kong',
                'currency_code' => 'HKD',
                'currency_name' => 'Hong Kong Dollar',
                'currency_symbol' => 'HK$',
                'phone_code' => '852',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Hong Kong',
                    'language' => 'Cantonese, English',
                    'timezone' => 'UTC+8',
                ]
            ],
            [
                'code' => 'TWN',
                'code_alpha2' => 'TW',
                'name' => 'Taiwan',
                'currency_code' => 'TWD',
                'currency_name' => 'New Taiwan Dollar',
                'currency_symbol' => 'NT$',
                'phone_code' => '886',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Taipei',
                    'language' => 'Mandarin',
                    'timezone' => 'UTC+8',
                ]
            ],
            [
                'code' => 'IND',
                'code_alpha2' => 'IN',
                'name' => 'India',
                'currency_code' => 'INR',
                'currency_name' => 'Indian Rupee',
                'currency_symbol' => '₹',
                'phone_code' => '91',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'New Delhi',
                    'language' => 'Hindi, English',
                    'timezone' => 'UTC+5:30',
                ]
            ],
            [
                'code' => 'PAK',
                'code_alpha2' => 'PK',
                'name' => 'Pakistan',
                'currency_code' => 'PKR',
                'currency_name' => 'Pakistani Rupee',
                'currency_symbol' => '₨',
                'phone_code' => '92',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Islamabad',
                    'language' => 'Urdu, English',
                    'timezone' => 'UTC+5',
                ]
            ],
            [
                'code' => 'BGD',
                'code_alpha2' => 'BD',
                'name' => 'Bangladesh',
                'currency_code' => 'BDT',
                'currency_name' => 'Bangladeshi Taka',
                'currency_symbol' => '৳',
                'phone_code' => '880',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Dhaka',
                    'language' => 'Bengali',
                    'timezone' => 'UTC+6',
                ]
            ],
            [
                'code' => 'NPL',
                'code_alpha2' => 'NP',
                'name' => 'Nepal',
                'currency_code' => 'NPR',
                'currency_name' => 'Nepalese Rupee',
                'currency_symbol' => '₨',
                'phone_code' => '977',
                'region' => 'Asia',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Kathmandu',
                    'language' => 'Nepali',
                    'timezone' => 'UTC+5:45',
                ]
            ],

            // MIDDLE EAST
            [
                'code' => 'ARE',
                'code_alpha2' => 'AE',
                'name' => 'United Arab Emirates',
                'currency_code' => 'AED',
                'currency_name' => 'UAE Dirham',
                'currency_symbol' => 'د.إ',
                'phone_code' => '971',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Abu Dhabi',
                    'language' => 'Arabic',
                    'timezone' => 'UTC+4',
                ]
            ],
            [
                'code' => 'SAU',
                'code_alpha2' => 'SA',
                'name' => 'Saudi Arabia',
                'currency_code' => 'SAR',
                'currency_name' => 'Saudi Riyal',
                'currency_symbol' => '﷼',
                'phone_code' => '966',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Riyadh',
                    'language' => 'Arabic',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'QAT',
                'code_alpha2' => 'QA',
                'name' => 'Qatar',
                'currency_code' => 'QAR',
                'currency_name' => 'Qatari Riyal',
                'currency_symbol' => '﷼',
                'phone_code' => '974',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Doha',
                    'language' => 'Arabic',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'KWT',
                'code_alpha2' => 'KW',
                'name' => 'Kuwait',
                'currency_code' => 'KWD',
                'currency_name' => 'Kuwaiti Dinar',
                'currency_symbol' => 'د.ك',
                'phone_code' => '965',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Kuwait City',
                    'language' => 'Arabic',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'BHR',
                'code_alpha2' => 'BH',
                'name' => 'Bahrain',
                'currency_code' => 'BHD',
                'currency_name' => 'Bahraini Dinar',
                'currency_symbol' => '.د.ب',
                'phone_code' => '973',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Manama',
                    'language' => 'Arabic',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'OMN',
                'code_alpha2' => 'OM',
                'name' => 'Oman',
                'currency_code' => 'OMR',
                'currency_name' => 'Omani Rial',
                'currency_symbol' => '﷼',
                'phone_code' => '968',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Muscat',
                    'language' => 'Arabic',
                    'timezone' => 'UTC+4',
                ]
            ],
            [
                'code' => 'ISR',
                'code_alpha2' => 'IL',
                'name' => 'Israel',
                'currency_code' => 'ILS',
                'currency_name' => 'Israeli New Shekel',
                'currency_symbol' => '₪',
                'phone_code' => '972',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Jerusalem',
                    'language' => 'Hebrew, Arabic',
                    'timezone' => 'UTC+2',
                ]
            ],
            [
                'code' => 'TUR',
                'code_alpha2' => 'TR',
                'name' => 'Turkey',
                'currency_code' => 'TRY',
                'currency_name' => 'Turkish Lira',
                'currency_symbol' => '₺',
                'phone_code' => '90',
                'region' => 'Middle East',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Ankara',
                    'language' => 'Turkish',
                    'timezone' => 'UTC+3',
                ]
            ],

            // EUROPE
            [
                'code' => 'GBR',
                'code_alpha2' => 'GB',
                'name' => 'United Kingdom',
                'currency_code' => 'GBP',
                'currency_name' => 'British Pound',
                'currency_symbol' => '£',
                'phone_code' => '44',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'London',
                    'language' => 'English',
                    'timezone' => 'UTC+0',
                ]
            ],
            [
                'code' => 'DEU',
                'code_alpha2' => 'DE',
                'name' => 'Germany',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '49',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Berlin',
                    'language' => 'German',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'FRA',
                'code_alpha2' => 'FR',
                'name' => 'France',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '33',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Paris',
                    'language' => 'French',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'ITA',
                'code_alpha2' => 'IT',
                'name' => 'Italy',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '39',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Rome',
                    'language' => 'Italian',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'ESP',
                'code_alpha2' => 'ES',
                'name' => 'Spain',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '34',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Madrid',
                    'language' => 'Spanish',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'NLD',
                'code_alpha2' => 'NL',
                'name' => 'Netherlands',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '31',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Amsterdam',
                    'language' => 'Dutch',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'CHE',
                'code_alpha2' => 'CH',
                'name' => 'Switzerland',
                'currency_code' => 'CHF',
                'currency_name' => 'Swiss Franc',
                'currency_symbol' => 'Fr',
                'phone_code' => '41',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Bern',
                    'language' => 'German, French, Italian, Romansh',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'SWE',
                'code_alpha2' => 'SE',
                'name' => 'Sweden',
                'currency_code' => 'SEK',
                'currency_name' => 'Swedish Krona',
                'currency_symbol' => 'kr',
                'phone_code' => '46',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Stockholm',
                    'language' => 'Swedish',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'NOR',
                'code_alpha2' => 'NO',
                'name' => 'Norway',
                'currency_code' => 'NOK',
                'currency_name' => 'Norwegian Krone',
                'currency_symbol' => 'kr',
                'phone_code' => '47',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Oslo',
                    'language' => 'Norwegian',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'DNK',
                'code_alpha2' => 'DK',
                'name' => 'Denmark',
                'currency_code' => 'DKK',
                'currency_name' => 'Danish Krone',
                'currency_symbol' => 'kr',
                'phone_code' => '45',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Copenhagen',
                    'language' => 'Danish',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'FIN',
                'code_alpha2' => 'FI',
                'name' => 'Finland',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '358',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Helsinki',
                    'language' => 'Finnish, Swedish',
                    'timezone' => 'UTC+2',
                ]
            ],
            [
                'code' => 'POL',
                'code_alpha2' => 'PL',
                'name' => 'Poland',
                'currency_code' => 'PLN',
                'currency_name' => 'Polish Złoty',
                'currency_symbol' => 'zł',
                'phone_code' => '48',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Warsaw',
                    'language' => 'Polish',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'AUT',
                'code_alpha2' => 'AT',
                'name' => 'Austria',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '43',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Vienna',
                    'language' => 'German',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'BEL',
                'code_alpha2' => 'BE',
                'name' => 'Belgium',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '32',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Brussels',
                    'language' => 'Dutch, French, German',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'IRL',
                'code_alpha2' => 'IE',
                'name' => 'Ireland',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '353',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Dublin',
                    'language' => 'English, Irish',
                    'timezone' => 'UTC+0',
                ]
            ],
            [
                'code' => 'PRT',
                'code_alpha2' => 'PT',
                'name' => 'Portugal',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '351',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Lisbon',
                    'language' => 'Portuguese',
                    'timezone' => 'UTC+0',
                ]
            ],
            [
                'code' => 'GRC',
                'code_alpha2' => 'GR',
                'name' => 'Greece',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '30',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Athens',
                    'language' => 'Greek',
                    'timezone' => 'UTC+2',
                ]
            ],
            [
                'code' => 'CZE',
                'code_alpha2' => 'CZ',
                'name' => 'Czech Republic',
                'currency_code' => 'CZK',
                'currency_name' => 'Czech Koruna',
                'currency_symbol' => 'Kč',
                'phone_code' => '420',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Prague',
                    'language' => 'Czech',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'HUN',
                'code_alpha2' => 'HU',
                'name' => 'Hungary',
                'currency_code' => 'HUF',
                'currency_name' => 'Hungarian Forint',
                'currency_symbol' => 'Ft',
                'phone_code' => '36',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Budapest',
                    'language' => 'Hungarian',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'ROU',
                'code_alpha2' => 'RO',
                'name' => 'Romania',
                'currency_code' => 'RON',
                'currency_name' => 'Romanian Leu',
                'currency_symbol' => 'lei',
                'phone_code' => '40',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Bucharest',
                    'language' => 'Romanian',
                    'timezone' => 'UTC+2',
                ]
            ],
            [
                'code' => 'BGR',
                'code_alpha2' => 'BG',
                'name' => 'Bulgaria',
                'currency_code' => 'BGN',
                'currency_name' => 'Bulgarian Lev',
                'currency_symbol' => 'лв',
                'phone_code' => '359',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Sofia',
                    'language' => 'Bulgarian',
                    'timezone' => 'UTC+2',
                ]
            ],
            [
                'code' => 'HRV',
                'code_alpha2' => 'HR',
                'name' => 'Croatia',
                'currency_code' => 'EUR',
                'currency_name' => 'Euro',
                'currency_symbol' => '€',
                'phone_code' => '385',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Zagreb',
                    'language' => 'Croatian',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'RUS',
                'code_alpha2' => 'RU',
                'name' => 'Russia',
                'currency_code' => 'RUB',
                'currency_name' => 'Russian Ruble',
                'currency_symbol' => '₽',
                'phone_code' => '7',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Moscow',
                    'language' => 'Russian',
                    'timezone' => 'UTC+3 to UTC+12',
                ]
            ],
            [
                'code' => 'UKR',
                'code_alpha2' => 'UA',
                'name' => 'Ukraine',
                'currency_code' => 'UAH',
                'currency_name' => 'Ukrainian Hryvnia',
                'currency_symbol' => '₴',
                'phone_code' => '380',
                'region' => 'Europe',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Kyiv',
                    'language' => 'Ukrainian',
                    'timezone' => 'UTC+2',
                ]
            ],

            // NORTH AMERICA
            [
                'code' => 'USA',
                'code_alpha2' => 'US',
                'name' => 'United States',
                'currency_code' => 'USD',
                'currency_name' => 'US Dollar',
                'currency_symbol' => '$',
                'phone_code' => '1',
                'region' => 'North America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Washington, D.C.',
                    'language' => 'English',
                    'timezone' => 'UTC-5 to UTC-10',
                ]
            ],
            [
                'code' => 'CAN',
                'code_alpha2' => 'CA',
                'name' => 'Canada',
                'currency_code' => 'CAD',
                'currency_name' => 'Canadian Dollar',
                'currency_symbol' => 'C$',
                'phone_code' => '1',
                'region' => 'North America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Ottawa',
                    'language' => 'English, French',
                    'timezone' => 'UTC-3:30 to UTC-8',
                ]
            ],
            [
                'code' => 'MEX',
                'code_alpha2' => 'MX',
                'name' => 'Mexico',
                'currency_code' => 'MXN',
                'currency_name' => 'Mexican Peso',
                'currency_symbol' => '$',
                'phone_code' => '52',
                'region' => 'North America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Mexico City',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-6 to UTC-8',
                ]
            ],

            // CARIBBEAN
            [
                'code' => 'JAM',
                'code_alpha2' => 'JM',
                'name' => 'Jamaica',
                'currency_code' => 'JMD',
                'currency_name' => 'Jamaican Dollar',
                'currency_symbol' => 'J$',
                'phone_code' => '1876',
                'region' => 'Caribbean',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Kingston',
                    'language' => 'English',
                    'timezone' => 'UTC-5',
                ]
            ],
            [
                'code' => 'DOM',
                'code_alpha2' => 'DO',
                'name' => 'Dominican Republic',
                'currency_code' => 'DOP',
                'currency_name' => 'Dominican Peso',
                'currency_symbol' => 'RD$',
                'phone_code' => '1809',
                'region' => 'Caribbean',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Santo Domingo',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-4',
                ]
            ],
            [
                'code' => 'TTO',
                'code_alpha2' => 'TT',
                'name' => 'Trinidad and Tobago',
                'currency_code' => 'TTD',
                'currency_name' => 'Trinidad and Tobago Dollar',
                'currency_symbol' => 'TT$',
                'phone_code' => '1868',
                'region' => 'Caribbean',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Port of Spain',
                    'language' => 'English',
                    'timezone' => 'UTC-4',
                ]
            ],

            // CENTRAL AMERICA
            [
                'code' => 'PAN',
                'code_alpha2' => 'PA',
                'name' => 'Panama',
                'currency_code' => 'PAB',
                'currency_name' => 'Panamanian Balboa',
                'currency_symbol' => 'B/.',
                'phone_code' => '507',
                'region' => 'Central America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Panama City',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-5',
                ]
            ],
            [
                'code' => 'CRI',
                'code_alpha2' => 'CR',
                'name' => 'Costa Rica',
                'currency_code' => 'CRC',
                'currency_name' => 'Costa Rican Colón',
                'currency_symbol' => '₡',
                'phone_code' => '506',
                'region' => 'Central America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'San José',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-6',
                ]
            ],

            // SOUTH AMERICA
            [
                'code' => 'BRA',
                'code_alpha2' => 'BR',
                'name' => 'Brazil',
                'currency_code' => 'BRL',
                'currency_name' => 'Brazilian Real',
                'currency_symbol' => 'R$',
                'phone_code' => '55',
                'region' => 'South America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Brasília',
                    'language' => 'Portuguese',
                    'timezone' => 'UTC-2 to UTC-5',
                ]
            ],
            [
                'code' => 'ARG',
                'code_alpha2' => 'AR',
                'name' => 'Argentina',
                'currency_code' => 'ARS',
                'currency_name' => 'Argentine Peso',
                'currency_symbol' => '$',
                'phone_code' => '54',
                'region' => 'South America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Buenos Aires',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-3',
                ]
            ],
            [
                'code' => 'COL',
                'code_alpha2' => 'CO',
                'name' => 'Colombia',
                'currency_code' => 'COP',
                'currency_name' => 'Colombian Peso',
                'currency_symbol' => '$',
                'phone_code' => '57',
                'region' => 'South America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Bogotá',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-5',
                ]
            ],
            [
                'code' => 'CHL',
                'code_alpha2' => 'CL',
                'name' => 'Chile',
                'currency_code' => 'CLP',
                'currency_name' => 'Chilean Peso',
                'currency_symbol' => '$',
                'phone_code' => '56',
                'region' => 'South America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Santiago',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-4',
                ]
            ],
            [
                'code' => 'PER',
                'code_alpha2' => 'PE',
                'name' => 'Peru',
                'currency_code' => 'PEN',
                'currency_name' => 'Peruvian Sol',
                'currency_symbol' => 'S/',
                'phone_code' => '51',
                'region' => 'South America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Lima',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-5',
                ]
            ],
            [
                'code' => 'ECU',
                'code_alpha2' => 'EC',
                'name' => 'Ecuador',
                'currency_code' => 'USD',
                'currency_name' => 'US Dollar',
                'currency_symbol' => '$',
                'phone_code' => '593',
                'region' => 'South America',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Quito',
                    'language' => 'Spanish',
                    'timezone' => 'UTC-5',
                ]
            ],

            // OCEANIA
            [
                'code' => 'AUS',
                'code_alpha2' => 'AU',
                'name' => 'Australia',
                'currency_code' => 'AUD',
                'currency_name' => 'Australian Dollar',
                'currency_symbol' => 'A$',
                'phone_code' => '61',
                'region' => 'Oceania',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Canberra',
                    'language' => 'English',
                    'timezone' => 'UTC+8 to UTC+11',
                ]
            ],
            [
                'code' => 'NZL',
                'code_alpha2' => 'NZ',
                'name' => 'New Zealand',
                'currency_code' => 'NZD',
                'currency_name' => 'New Zealand Dollar',
                'currency_symbol' => 'NZ$',
                'phone_code' => '64',
                'region' => 'Oceania',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Wellington',
                    'language' => 'English, Māori',
                    'timezone' => 'UTC+12',
                ]
            ],
            [
                'code' => 'FJI',
                'code_alpha2' => 'FJ',
                'name' => 'Fiji',
                'currency_code' => 'FJD',
                'currency_name' => 'Fijian Dollar',
                'currency_symbol' => 'FJ$',
                'phone_code' => '679',
                'region' => 'Oceania',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Suva',
                    'language' => 'English, Fijian, Fiji Hindi',
                    'timezone' => 'UTC+12',
                ]
            ],

            // AFRICA
            [
                'code' => 'ZAF',
                'code_alpha2' => 'ZA',
                'name' => 'South Africa',
                'currency_code' => 'ZAR',
                'currency_name' => 'South African Rand',
                'currency_symbol' => 'R',
                'phone_code' => '27',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Pretoria, Cape Town, Bloemfontein',
                    'language' => '11 official languages including English, Afrikaans, Zulu',
                    'timezone' => 'UTC+2',
                ]
            ],
            [
                'code' => 'EGY',
                'code_alpha2' => 'EG',
                'name' => 'Egypt',
                'currency_code' => 'EGP',
                'currency_name' => 'Egyptian Pound',
                'currency_symbol' => 'E£',
                'phone_code' => '20',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Cairo',
                    'language' => 'Arabic',
                    'timezone' => 'UTC+2',
                ]
            ],
            [
                'code' => 'NGA',
                'code_alpha2' => 'NG',
                'name' => 'Nigeria',
                'currency_code' => 'NGN',
                'currency_name' => 'Nigerian Naira',
                'currency_symbol' => '₦',
                'phone_code' => '234',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Abuja',
                    'language' => 'English',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'KEN',
                'code_alpha2' => 'KE',
                'name' => 'Kenya',
                'currency_code' => 'KES',
                'currency_name' => 'Kenyan Shilling',
                'currency_symbol' => 'KSh',
                'phone_code' => '254',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Nairobi',
                    'language' => 'English, Swahili',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'GHA',
                'code_alpha2' => 'GH',
                'name' => 'Ghana',
                'currency_code' => 'GHS',
                'currency_name' => 'Ghanaian Cedi',
                'currency_symbol' => '₵',
                'phone_code' => '233',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Accra',
                    'language' => 'English',
                    'timezone' => 'UTC+0',
                ]
            ],
            [
                'code' => 'MAR',
                'code_alpha2' => 'MA',
                'name' => 'Morocco',
                'currency_code' => 'MAD',
                'currency_name' => 'Moroccan Dirham',
                'currency_symbol' => 'د.م.',
                'phone_code' => '212',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Rabat',
                    'language' => 'Arabic, Berber',
                    'timezone' => 'UTC+1',
                ]
            ],
            [
                'code' => 'TZA',
                'code_alpha2' => 'TZ',
                'name' => 'Tanzania',
                'currency_code' => 'TZS',
                'currency_name' => 'Tanzanian Shilling',
                'currency_symbol' => 'TSh',
                'phone_code' => '255',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Dodoma',
                    'language' => 'Swahili, English',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'ETH',
                'code_alpha2' => 'ET',
                'name' => 'Ethiopia',
                'currency_code' => 'ETB',
                'currency_name' => 'Ethiopian Birr',
                'currency_symbol' => 'Br',
                'phone_code' => '251',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Addis Ababa',
                    'language' => 'Amharic',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'UGA',
                'code_alpha2' => 'UG',
                'name' => 'Uganda',
                'currency_code' => 'UGX',
                'currency_name' => 'Ugandan Shilling',
                'currency_symbol' => 'USh',
                'phone_code' => '256',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Kampala',
                    'language' => 'English, Swahili',
                    'timezone' => 'UTC+3',
                ]
            ],
            [
                'code' => 'SEN',
                'code_alpha2' => 'SN',
                'name' => 'Senegal',
                'currency_code' => 'XOF',
                'currency_name' => 'West African CFA franc',
                'currency_symbol' => 'CFA',
                'phone_code' => '221',
                'region' => 'Africa',
                'is_active' => true,
                'metadata' => [
                    'capital' => 'Dakar',
                    'language' => 'French',
                    'timezone' => 'UTC+0',
                ]
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}

