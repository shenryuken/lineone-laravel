<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Local Malaysian Banks
        Bank::create([
            'name' => 'Maybank',
            'code' => 'MBB',
            'swift_code' => 'MBBEMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD'],
            'description' => 'Malayan Banking Berhad is the largest financial services group in Malaysia.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1960',
                'website' => 'https://www.maybank.com'
            ]
        ]);

        Bank::create([
            'name' => 'CIMB Bank',
            'code' => 'CIMB',
            'swift_code' => 'CIBBMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD', 'THB'],
            'description' => 'CIMB Group is a leading ASEAN universal bank and one of the largest investment banks in Asia.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1974',
                'website' => 'https://www.cimb.com'
            ]
        ]);

        Bank::create([
            'name' => 'Public Bank',
            'code' => 'PBB',
            'swift_code' => 'PBBEMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD', 'CNY'],
            'description' => 'Public Bank Berhad is a major banking group in Malaysia offering a comprehensive range of financial services.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1966',
                'website' => 'https://www.pbebank.com'
            ]
        ]);

        Bank::create([
            'name' => 'RHB Bank',
            'code' => 'RHB',
            'swift_code' => 'RHBBMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD', 'THB'],
            'description' => 'RHB Bank is a multinational regional financial services provider that is engaged in commercial banking and investment banking.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1997',
                'website' => 'https://www.rhbgroup.com'
            ]
        ]);

        Bank::create([
            'name' => 'Hong Leong Bank',
            'code' => 'HLB',
            'swift_code' => 'HLBBMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD', 'AUD'],
            'description' => 'Hong Leong Bank is a major banking group in Malaysia providing comprehensive financial services.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1905',
                'website' => 'https://www.hlb.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'AmBank',
            'code' => 'AMB',
            'swift_code' => 'ARBKMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD'],
            'description' => 'AmBank Group is one of Malaysia\'s premier financial solutions groups with nearly 40 years of legacy in banking.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1975',
                'website' => 'https://www.ambankgroup.com'
            ]
        ]);

        Bank::create([
            'name' => 'Bank Islam Malaysia',
            'code' => 'BIMB',
            'swift_code' => 'BIMBMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD'],
            'description' => 'Bank Islam Malaysia Berhad is Malaysia\'s first Shariah-based financial institution.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1983',
                'website' => 'https://www.bankislam.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'Alliance Bank',
            'code' => 'ALB',
            'swift_code' => 'MFBBMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD'],
            'description' => 'Alliance Bank Malaysia Berhad is a dynamic, integrated financial services group offering banking and financial solutions.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1958',
                'website' => 'https://www.alliancebank.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'Bank Rakyat',
            'code' => 'BRK',
            'swift_code' => 'BKRMMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR'],
            'description' => 'Bank Rakyat is the largest Islamic cooperative bank in Malaysia focusing on providing Shariah-compliant banking products.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1954',
                'website' => 'https://www.bankrakyat.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'Affin Bank',
            'code' => 'AFB',
            'swift_code' => 'PHBMMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD'],
            'description' => 'Affin Bank Berhad is a financial services conglomerate in Malaysia offering a suite of financial products and services.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1975',
                'website' => 'https://www.affinbank.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'OCBC Bank Malaysia',
            'code' => 'OCBC',
            'swift_code' => 'OCBCMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD', 'CNY'],
            'description' => 'OCBC Bank Malaysia is a subsidiary of OCBC Bank Singapore, offering a wide range of banking services.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1932',
                'website' => 'https://www.ocbc.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'UOB Malaysia',
            'code' => 'UOB',
            'swift_code' => 'UOVBMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SGD', 'THB'],
            'description' => 'United Overseas Bank (Malaysia) Bhd is a subsidiary of UOB Singapore, providing comprehensive financial services.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1993',
                'website' => 'https://www.uob.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'Bank Muamalat Malaysia',
            'code' => 'BMM',
            'swift_code' => 'BMMBMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD'],
            'description' => 'Bank Muamalat Malaysia Berhad is the second full-fledged Islamic bank established in Malaysia.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1999',
                'website' => 'https://www.muamalat.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'Standard Chartered Malaysia',
            'code' => 'SCB',
            'swift_code' => 'SCBLMYKX',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'GBP', 'EUR', 'SGD'],
            'description' => 'Standard Chartered Bank Malaysia Berhad is a member of the Standard Chartered Group, offering a wide range of banking products.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '1875',
                'website' => 'https://www.sc.com/my'
            ]
        ]);

        Bank::create([
            'name' => 'MBSB Bank',
            'code' => 'MBSB',
            'swift_code' => 'AFBQMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD'],
            'description' => 'MBSB Bank is a full-fledged Islamic bank in Malaysia offering Shariah-compliant financial solutions.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '2018',
                'website' => 'https://www.mbsbbank.com'
            ]
        ]);

        Bank::create([
            'name' => 'Al-Rajhi Bank Malaysia',
            'code' => 'ARB',
            'swift_code' => 'RJHIMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'SAR'],
            'description' => 'Al-Rajhi Bank Malaysia is a subsidiary of Al-Rajhi Bank Saudi Arabia, offering Islamic banking services.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '2006',
                'website' => 'https://www.alrajhibank.com.my'
            ]
        ]);

        Bank::create([
            'name' => 'Kuwait Finance House Malaysia',
            'code' => 'KFH',
            'swift_code' => 'KFHOMYKL',
            'type' => 'local',
            'country_code' => 'MYS',
            'country_name' => 'Malaysia',
            'supported_currencies' => ['MYR', 'USD', 'KWD'],
            'description' => 'Kuwait Finance House Malaysia Berhad is a subsidiary of Kuwait Finance House Kuwait, offering Islamic banking services.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Kuala Lumpur',
                'founded' => '2005',
                'website' => 'https://www.kfh.com.my'
            ]
        ]);

        // International Banks
        Bank::create([
            'name' => 'HSBC',
            'code' => 'HSBC',
            'swift_code' => 'HSBCGB2L',
            'type' => 'international',
            'country_code' => 'GBR',
            'country_name' => 'United Kingdom',
            'supported_currencies' => ['USD', 'GBP', 'EUR', 'JPY', 'MYR', 'SGD'],
            'description' => 'HSBC Holdings plc is a British multinational investment bank and financial services holding company.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'London',
                'founded' => '1865',
                'website' => 'https://www.hsbc.com'
            ]
        ]);

        Bank::create([
            'name' => 'Citibank',
            'code' => 'CITI',
            'swift_code' => 'CITIUS33',
            'type' => 'international',
            'country_code' => 'USA',
            'country_name' => 'United States',
            'supported_currencies' => ['USD', 'EUR', 'GBP', 'JPY', 'MYR', 'SGD', 'AUD'],
            'description' => 'Citibank is the consumer division of financial services multinational Citigroup.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'New York City',
                'founded' => '1812',
                'website' => 'https://www.citibank.com'
            ]
        ]);

        Bank::create([
            'name' => 'DBS Bank',
            'code' => 'DBS',
            'swift_code' => 'DBSSSGSG',
            'type' => 'international',
            'country_code' => 'SGP',
            'country_name' => 'Singapore',
            'supported_currencies' => ['SGD', 'USD', 'MYR', 'IDR', 'THB'],
            'description' => 'DBS Bank is a Singaporean multinational banking and financial services corporation.',
            'is_active' => true,
            'metadata' => [
                'headquarters' => 'Singapore',
                'founded' => '1968',
                'website' => 'https://www.dbs.com'
            ]
        ]);
    }
}

