<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 2)->unique(); // ISO 3166-1 alpha-2 code
            $table->string('phone_code', 10)->nullable(); // Country calling code
            $table->string('phone_format')->nullable(); // Example phone number format
            $table->boolean('active')->default(true);
            $table->timestamps();

            // Add indexes for better performance
            $table->index('name');
            $table->index('code');
            $table->index('phone_code');
        });

        // Populate the table with countries
        $this->seedCountries();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }

    /**
     * Seed the countries table with a comprehensive list of countries.
     *
     * @return void
     */
    private function seedCountries()
    {
        $countries = [
            ['name' => 'Afghanistan', 'code' => 'AF', 'phone_code' => '93', 'phone_format' => '+93 70 123 4567'],
            ['name' => 'Åland Islands', 'code' => 'AX', 'phone_code' => '358', 'phone_format' => '+358 18 1234567'],
            ['name' => 'Albania', 'code' => 'AL', 'phone_code' => '355', 'phone_format' => '+355 69 123 4567'],
            ['name' => 'Algeria', 'code' => 'DZ', 'phone_code' => '213', 'phone_format' => '+213 551 23 45 67'],
            ['name' => 'American Samoa', 'code' => 'AS', 'phone_code' => '1684', 'phone_format' => '+1 684 733 1234'],
            ['name' => 'Andorra', 'code' => 'AD', 'phone_code' => '376', 'phone_format' => '+376 312 345'],
            ['name' => 'Angola', 'code' => 'AO', 'phone_code' => '244', 'phone_format' => '+244 923 123 456'],
            ['name' => 'Anguilla', 'code' => 'AI', 'phone_code' => '1264', 'phone_format' => '+1 264 235 1234'],
            ['name' => 'Antarctica', 'code' => 'AQ', 'phone_code' => '672', 'phone_format' => '+672 1 2345'],
            ['name' => 'Antigua and Barbuda', 'code' => 'AG', 'phone_code' => '1268', 'phone_format' => '+1 268 464 1234'],
            ['name' => 'Argentina', 'code' => 'AR', 'phone_code' => '54', 'phone_format' => '+54 9 11 1234 5678'],
            ['name' => 'Armenia', 'code' => 'AM', 'phone_code' => '374', 'phone_format' => '+374 77 123456'],
            ['name' => 'Aruba', 'code' => 'AW', 'phone_code' => '297', 'phone_format' => '+297 560 1234'],
            ['name' => 'Australia', 'code' => 'AU', 'phone_code' => '61', 'phone_format' => '+61 4 1234 5678'],
            ['name' => 'Austria', 'code' => 'AT', 'phone_code' => '43', 'phone_format' => '+43 664 123456'],
            ['name' => 'Azerbaijan', 'code' => 'AZ', 'phone_code' => '994', 'phone_format' => '+994 50 123 45 67'],
            ['name' => 'Bahamas', 'code' => 'BS', 'phone_code' => '1242', 'phone_format' => '+1 242 359 1234'],
            ['name' => 'Bahrain', 'code' => 'BH', 'phone_code' => '973', 'phone_format' => '+973 3600 1234'],
            ['name' => 'Bangladesh', 'code' => 'BD', 'phone_code' => '880', 'phone_format' => '+880 1812 345678'],
            ['name' => 'Barbados', 'code' => 'BB', 'phone_code' => '1246', 'phone_format' => '+1 246 250 1234'],
            ['name' => 'Belarus', 'code' => 'BY', 'phone_code' => '375', 'phone_format' => '+375 29 123 45 67'],
            ['name' => 'Belgium', 'code' => 'BE', 'phone_code' => '32', 'phone_format' => '+32 470 12 34 56'],
            ['name' => 'Belize', 'code' => 'BZ', 'phone_code' => '501', 'phone_format' => '+501 622 1234'],
            ['name' => 'Benin', 'code' => 'BJ', 'phone_code' => '229', 'phone_format' => '+229 90 12 3456'],
            ['name' => 'Bermuda', 'code' => 'BM', 'phone_code' => '1441', 'phone_format' => '+1 441 370 1234'],
            ['name' => 'Bhutan', 'code' => 'BT', 'phone_code' => '975', 'phone_format' => '+975 17 12 3456'],
            ['name' => 'Bolivia', 'code' => 'BO', 'phone_code' => '591', 'phone_format' => '+591 71234567'],
            ['name' => 'Bosnia and Herzegovina', 'code' => 'BA', 'phone_code' => '387', 'phone_format' => '+387 61 123 456'],
            ['name' => 'Botswana', 'code' => 'BW', 'phone_code' => '267', 'phone_format' => '+267 71 123 456'],
            ['name' => 'Bouvet Island', 'code' => 'BV', 'phone_code' => '47', 'phone_format' => '+47 412 34 567'],
            ['name' => 'Brazil', 'code' => 'BR', 'phone_code' => '55', 'phone_format' => '+55 11 91234 5678'],
            ['name' => 'British Indian Ocean Territory', 'code' => 'IO', 'phone_code' => '246', 'phone_format' => '+246 380 1234'],
            ['name' => 'Brunei Darussalam', 'code' => 'BN', 'phone_code' => '673', 'phone_format' => '+673 712 3456'],
            ['name' => 'Bulgaria', 'code' => 'BG', 'phone_code' => '359', 'phone_format' => '+359 48 123 456'],
            ['name' => 'Burkina Faso', 'code' => 'BF', 'phone_code' => '226', 'phone_format' => '+226 70 12 34 56'],
            ['name' => 'Burundi', 'code' => 'BI', 'phone_code' => '257', 'phone_format' => '+257 79 56 12 34'],
            ['name' => 'Cambodia', 'code' => 'KH', 'phone_code' => '855', 'phone_format' => '+855 12 345 678'],
            ['name' => 'Cameroon', 'code' => 'CM', 'phone_code' => '237', 'phone_format' => '+237 6 71 23 45 67'],
            ['name' => 'Canada', 'code' => 'CA', 'phone_code' => '1', 'phone_format' => '+1 204 123 4567'],
            ['name' => 'Cape Verde', 'code' => 'CV', 'phone_code' => '238', 'phone_format' => '+238 991 1234'],
            ['name' => 'Cayman Islands', 'code' => 'KY', 'phone_code' => '1345', 'phone_format' => '+1 345 323 1234'],
            ['name' => 'Central African Republic', 'code' => 'CF', 'phone_code' => '236', 'phone_format' => '+236 70 01 23 45'],
            ['name' => 'Chad', 'code' => 'TD', 'phone_code' => '235', 'phone_format' => '+235 63 01 23 45'],
            ['name' => 'Chile', 'code' => 'CL', 'phone_code' => '56', 'phone_format' => '+56 9 1234 5678'],
            ['name' => 'China', 'code' => 'CN', 'phone_code' => '86', 'phone_format' => '+86 131 2345 6789'],
            ['name' => 'Christmas Island', 'code' => 'CX', 'phone_code' => '61', 'phone_format' => '+61 8 9164 1234'],
            ['name' => 'Cocos (Keeling) Islands', 'code' => 'CC', 'phone_code' => '61', 'phone_format' => '+61 8 9162 1234'],
            ['name' => 'Colombia', 'code' => 'CO', 'phone_code' => '57', 'phone_format' => '+57 321 1234567'],
            ['name' => 'Comoros', 'code' => 'KM', 'phone_code' => '269', 'phone_format' => '+269 321 23 45'],
            ['name' => 'Congo', 'code' => 'CG', 'phone_code' => '242', 'phone_format' => '+242 06 123 4567'],
            ['name' => 'Congo, Democratic Republic of the', 'code' => 'CD', 'phone_code' => '243', 'phone_format' => '+243 81 234 5678'],
            ['name' => 'Cook Islands', 'code' => 'CK', 'phone_code' => '682', 'phone_format' => '+682 71 234'],
            ['name' => 'Costa Rica', 'code' => 'CR', 'phone_code' => '506', 'phone_format' => '+506 8123 4567'],
            ['name' => 'Côte d\'Ivoire', 'code' => 'CI', 'phone_code' => '225', 'phone_format' => '+225 01 23 45 67 89'],
            ['name' => 'Croatia', 'code' => 'HR', 'phone_code' => '385', 'phone_format' => '+385 91 234 5678'],
            ['name' => 'Cuba', 'code' => 'CU', 'phone_code' => '53', 'phone_format' => '+53 5 1234567'],
            ['name' => 'Cyprus', 'code' => 'CY', 'phone_code' => '357', 'phone_format' => '+357 96 123456'],
            ['name' => 'Czech Republic', 'code' => 'CZ', 'phone_code' => '420', 'phone_format' => '+420 601 123 456'],
            ['name' => 'Denmark', 'code' => 'DK', 'phone_code' => '45', 'phone_format' => '+45 20 12 34 56'],
            ['name' => 'Djibouti', 'code' => 'DJ', 'phone_code' => '253', 'phone_format' => '+253 77 83 10 01'],
            ['name' => 'Dominica', 'code' => 'DM', 'phone_code' => '1767', 'phone_format' => '+1 767 225 1234'],
            ['name' => 'Dominican Republic', 'code' => 'DO', 'phone_code' => '1809', 'phone_format' => '+1 809 234 5678'],
            ['name' => 'Ecuador', 'code' => 'EC', 'phone_code' => '593', 'phone_format' => '+593 99 123 4567'],
            ['name' => 'Egypt', 'code' => 'EG', 'phone_code' => '20', 'phone_format' => '+20 100 123 4567'],
            ['name' => 'El Salvador', 'code' => 'SV', 'phone_code' => '503', 'phone_format' => '+503 7123 4567'],
            ['name' => 'Equatorial Guinea', 'code' => 'GQ', 'phone_code' => '240', 'phone_format' => '+240 222 123 456'],
            ['name' => 'Eritrea', 'code' => 'ER', 'phone_code' => '291', 'phone_format' => '+291 7 123 456'],
            ['name' => 'Estonia', 'code' => 'EE', 'phone_code' => '372', 'phone_format' => '+372 5123 456'],
            ['name' => 'Ethiopia', 'code' => 'ET', 'phone_code' => '251', 'phone_format' => '+251 91 123 4567'],
            ['name' => 'Falkland Islands (Malvinas)', 'code' => 'FK', 'phone_code' => '500', 'phone_format' => '+500 51234'],
            ['name' => 'Faroe Islands', 'code' => 'FO', 'phone_code' => '298', 'phone_format' => '+298 211234'],
            ['name' => 'Fiji', 'code' => 'FJ', 'phone_code' => '679', 'phone_format' => '+679 701 2345'],
            ['name' => 'Finland', 'code' => 'FI', 'phone_code' => '358', 'phone_format' => '+358 40 1234567'],
            ['name' => 'France', 'code' => 'FR', 'phone_code' => '33', 'phone_format' => '+33 6 12 34 56 78'],
            ['name' => 'French Guiana', 'code' => 'GF', 'phone_code' => '594', 'phone_format' => '+594 694 20 12 34'],
            ['name' => 'French Polynesia', 'code' => 'PF', 'phone_code' => '689', 'phone_format' => '+689 87 12 34 56'],
            ['name' => 'French Southern Territories', 'code' => 'TF', 'phone_code' => '262', 'phone_format' => '+262 692 12 34 56'],
            ['name' => 'Gabon', 'code' => 'GA', 'phone_code' => '241', 'phone_format' => '+241 06 03 12 34'],
            ['name' => 'Gambia', 'code' => 'GM', 'phone_code' => '220', 'phone_format' => '+220 301 2345'],
            ['name' => 'Georgia', 'code' => 'GE', 'phone_code' => '995', 'phone_format' => '+995 555 12 34 56'],
            ['name' => 'Germany', 'code' => 'DE', 'phone_code' => '49', 'phone_format' => '+49 151 123 45678'],
            ['name' => 'Ghana', 'code' => 'GH', 'phone_code' => '233', 'phone_format' => '+233 24 123 4567'],
            ['name' => 'Gibraltar', 'code' => 'GI', 'phone_code' => '350', 'phone_format' => '+350 57123456'],
            ['name' => 'Greece', 'code' => 'GR', 'phone_code' => '30', 'phone_format' => '+30 691 234 5678'],
            ['name' => 'Greenland', 'code' => 'GL', 'phone_code' => '299', 'phone_format' => '+299 22 12 34'],
            ['name' => 'Grenada', 'code' => 'GD', 'phone_code' => '1473', 'phone_format' => '+1 473 403 1234'],
            ['name' => 'Guadeloupe', 'code' => 'GP', 'phone_code' => '590', 'phone_format' => '+590 690 12 34 56'],
            ['name' => 'Guam', 'code' => 'GU', 'phone_code' => '1671', 'phone_format' => '+1 671 300 1234'],
            ['name' => 'Guatemala', 'code' => 'GT', 'phone_code' => '502', 'phone_format' => '+502 5123 4567'],
            ['name' => 'Guernsey', 'code' => 'GG', 'phone_code' => '44', 'phone_format' => '+44 7781 123456'],
            ['name' => 'Guinea', 'code' => 'GN', 'phone_code' => '224', 'phone_format' => '+224 601 12 34 56'],
            ['name' => 'Guinea-Bissau', 'code' => 'GW', 'phone_code' => '245', 'phone_format' => '+245 955 012 345'],
            ['name' => 'Guyana', 'code' => 'GY', 'phone_code' => '592', 'phone_format' => '+592 609 1234'],
            ['name' => 'Haiti', 'code' => 'HT', 'phone_code' => '509', 'phone_format' => '+509 34 10 1234'],
            ['name' => 'Heard Island and McDonald Islands', 'code' => 'HM', 'phone_code' => '672', 'phone_format' => '+672 1 2345'],
            ['name' => 'Holy See (Vatican City State)', 'code' => 'VA', 'phone_code' => '39', 'phone_format' => '+39 06 698 12345'],
            ['name' => 'Honduras', 'code' => 'HN', 'phone_code' => '504', 'phone_format' => '+504 9123 4567'],
            ['name' => 'Hong Kong', 'code' => 'HK', 'phone_code' => '852', 'phone_format' => '+852 5123 4567'],
            ['name' => 'Hungary', 'code' => 'HU', 'phone_code' => '36', 'phone_format' => '+36 20 123 4567'],
            ['name' => 'Iceland', 'code' => 'IS', 'phone_code' => '354', 'phone_format' => '+354 611 1234'],
            ['name' => 'India', 'code' => 'IN', 'phone_code' => '91', 'phone_format' => '+91 98765 43210'],
            ['name' => 'Indonesia', 'code' => 'ID', 'phone_code' => '62', 'phone_format' => '+62 812-345-678'],
            ['name' => 'Iran, Islamic Republic of', 'code' => 'IR', 'phone_code' => '98', 'phone_format' => '+98 912 345 6789'],
            ['name' => 'Iraq', 'code' => 'IQ', 'phone_code' => '964', 'phone_format' => '+964 750 123 4567'],
            ['name' => 'Ireland', 'code' => 'IE', 'phone_code' => '353', 'phone_format' => '+353 85 123 4567'],
            ['name' => 'Isle of Man', 'code' => 'IM', 'phone_code' => '44', 'phone_format' => '+44 7924 123456'],
            ['name' => 'Israel', 'code' => 'IL', 'phone_code' => '972', 'phone_format' => '+972 50-123-4567'],
            ['name' => 'Italy', 'code' => 'IT', 'phone_code' => '39', 'phone_format' => '+39 312 345 6789'],
            ['name' => 'Jamaica', 'code' => 'JM', 'phone_code' => '1876', 'phone_format' => '+1 876 210 1234'],
            ['name' => 'Japan', 'code' => 'JP', 'phone_code' => '81', 'phone_format' => '+81 90-1234-5678'],
            ['name' => 'Jersey', 'code' => 'JE', 'phone_code' => '44', 'phone_format' => '+44 7797 123456'],
            ['name' => 'Jordan', 'code' => 'JO', 'phone_code' => '962', 'phone_format' => '+962 7 9012 3456'],
            ['name' => 'Kazakhstan', 'code' => 'KZ', 'phone_code' => '7', 'phone_format' => '+7 701 123 4567'],
            ['name' => 'Kenya', 'code' => 'KE', 'phone_code' => '254', 'phone_format' => '+254 712 345678'],
            ['name' => 'Kiribati', 'code' => 'KI', 'phone_code' => '686', 'phone_format' => '+686 30123'],
            ['name' => 'Korea, Democratic People\'s Republic of', 'code' => 'KP', 'phone_code' => '850', 'phone_format' => '+850 192 123 4567'],
            ['name' => 'Korea, Republic of', 'code' => 'KR', 'phone_code' => '82', 'phone_format' => '+82 10-1234-5678'],
            ['name' => 'Kuwait', 'code' => 'KW', 'phone_code' => '965', 'phone_format' => '+965 500 12345'],
            ['name' => 'Kyrgyzstan', 'code' => 'KG', 'phone_code' => '996', 'phone_format' => '+996 700 123 456'],
            ['name' => 'Lao People\'s Democratic Republic', 'code' => 'LA', 'phone_code' => '856', 'phone_format' => '+856 20 23 123 456'],
            ['name' => 'Latvia', 'code' => 'LV', 'phone_code' => '371', 'phone_format' => '+371 21 234 567'],
            ['name' => 'Lebanon', 'code' => 'LB', 'phone_code' => '961', 'phone_format' => '+961 71 123 456'],
            ['name' => 'Lesotho', 'code' => 'LS', 'phone_code' => '266', 'phone_format' => '+266 5012 3456'],
            ['name' => 'Liberia', 'code' => 'LR', 'phone_code' => '231', 'phone_format' => '+231 77 012 3456'],
            ['name' => 'Libya', 'code' => 'LY', 'phone_code' => '218', 'phone_format' => '+218 91-2345678'],
            ['name' => 'Liechtenstein', 'code' => 'LI', 'phone_code' => '423', 'phone_format' => '+423 660 234 567'],
            ['name' => 'Lithuania', 'code' => 'LT', 'phone_code' => '370', 'phone_format' => '+370 612 34567'],
            ['name' => 'Luxembourg', 'code' => 'LU', 'phone_code' => '352', 'phone_format' => '+352 628 123 456'],
            ['name' => 'Macao', 'code' => 'MO', 'phone_code' => '853', 'phone_format' => '+853 6612 3456'],
            ['name' => 'Macedonia, the former Yugoslav Republic of', 'code' => 'MK', 'phone_code' => '389', 'phone_format' => '+389 72 123 456'],
            ['name' => 'Madagascar', 'code' => 'MG', 'phone_code' => '261', 'phone_format' => '+261 32 12 345 67'],
            ['name' => 'Malawi', 'code' => 'MW', 'phone_code' => '265', 'phone_format' => '+265 888 123 456'],
            ['name' => 'Malaysia', 'code' => 'MY', 'phone_code' => '60', 'phone_format' => '+60 12-345 6789'],
            ['name' => 'Maldives', 'code' => 'MV', 'phone_code' => '960', 'phone_format' => '+960 771-2345'],
            ['name' => 'Mali', 'code' => 'ML', 'phone_code' => '223', 'phone_format' => '+223 65 12 34 56'],
            ['name' => 'Malta', 'code' => 'MT', 'phone_code' => '356', 'phone_format' => '+356 9696 1234'],
            ['name' => 'Marshall Islands', 'code' => 'MH', 'phone_code' => '692', 'phone_format' => '+692 235 1234'],
            ['name' => 'Martinique', 'code' => 'MQ', 'phone_code' => '596', 'phone_format' => '+596 696 20 12 34'],
            ['name' => 'Mauritania', 'code' => 'MR', 'phone_code' => '222', 'phone_format' => '+222 22 12 34 56'],
            ['name' => 'Mauritius', 'code' => 'MU', 'phone_code' => '230', 'phone_format' => '+230 5251 2345'],
            ['name' => 'Mayotte', 'code' => 'YT', 'phone_code' => '262', 'phone_format' => '+262 639 12 34 56'],
            ['name' => 'Mexico', 'code' => 'MX', 'phone_code' => '52', 'phone_format' => '+52 1 222 123 4567'],
            ['name' => 'Micronesia, Federated States of', 'code' => 'FM', 'phone_code' => '691', 'phone_format' => '+691 350 1234'],
            ['name' => 'Moldova, Republic of', 'code' => 'MD', 'phone_code' => '373', 'phone_format' => '+373 621 12 345'],
            ['name' => 'Monaco', 'code' => 'MC', 'phone_code' => '377', 'phone_format' => '+377 6 12 34 56 78'],
            ['name' => 'Mongolia', 'code' => 'MN', 'phone_code' => '976', 'phone_format' => '+976 8812 3456'],
            ['name' => 'Montenegro', 'code' => 'ME', 'phone_code' => '382', 'phone_format' => '+382 67 622 901'],
            ['name' => 'Montserrat', 'code' => 'MS', 'phone_code' => '1664', 'phone_format' => '+1 664 492 3456'],
            ['name' => 'Morocco', 'code' => 'MA', 'phone_code' => '212', 'phone_format' => '+212 6-1234-5678'],
            ['name' => 'Mozambique', 'code' => 'MZ', 'phone_code' => '258', 'phone_format' => '+258 82 123 4567'],
            ['name' => 'Myanmar', 'code' => 'MM', 'phone_code' => '95', 'phone_format' => '+95 9 212 3456'],
            ['name' => 'Namibia', 'code' => 'NA', 'phone_code' => '264', 'phone_format' => '+264 81 123 4567'],
            ['name' => 'Nauru', 'code' => 'NR', 'phone_code' => '674', 'phone_format' => '+674 555 1234'],
            ['name' => 'Nepal', 'code' => 'NP', 'phone_code' => '977', 'phone_format' => '+977 984 1234567'],
            ['name' => 'Netherlands', 'code' => 'NL', 'phone_code' => '31', 'phone_format' => '+31 6 12345678'],
            ['name' => 'New Caledonia', 'code' => 'NC', 'phone_code' => '687', 'phone_format' => '+687 75 12 34'],
            ['name' => 'New Zealand', 'code' => 'NZ', 'phone_code' => '64', 'phone_format' => '+64 21 123 4567'],
            ['name' => 'Nicaragua', 'code' => 'NI', 'phone_code' => '505', 'phone_format' => '+505 8123 4567'],
            ['name' => 'Niger', 'code' => 'NE', 'phone_code' => '227', 'phone_format' => '+227 93 12 34 56'],
            ['name' => 'Nigeria', 'code' => 'NG', 'phone_code' => '234', 'phone_format' => '+234 802 123 4567'],
            ['name' => 'Niue', 'code' => 'NU', 'phone_code' => '683', 'phone_format' => '+683 4123'],
            ['name' => 'Norfolk Island', 'code' => 'NF', 'phone_code' => '672', 'phone_format' => '+672 3 81234'],
            ['name' => 'Northern Mariana Islands', 'code' => 'MP', 'phone_code' => '1670', 'phone_format' => '+1 670 234 5678'],
            ['name' => 'Norway', 'code' => 'NO', 'phone_code' => '47', 'phone_format' => '+47 406 12 345'],
            ['name' => 'Oman', 'code' => 'OM', 'phone_code' => '968', 'phone_format' => '+968 9212 3456'],
            ['name' => 'Pakistan', 'code' => 'PK', 'phone_code' => '92', 'phone_format' => '+92 301 2345678'],
            ['name' => 'Palau', 'code' => 'PW', 'phone_code' => '680', 'phone_format' => '+680 779 1234'],
            ['name' => 'Palestine, State of', 'code' => 'PS', 'phone_code' => '970', 'phone_format' => '+970 59 123 4567'],
            ['name' => 'Panama', 'code' => 'PA', 'phone_code' => '507', 'phone_format' => '+507 6123 4567'],
            ['name' => 'Papua New Guinea', 'code' => 'PG', 'phone_code' => '675', 'phone_format' => '+675 681 2345'],
            ['name' => 'Paraguay', 'code' => 'PY', 'phone_code' => '595', 'phone_format' => '+595 981 123456'],
            ['name' => 'Peru', 'code' => 'PE', 'phone_code' => '51', 'phone_format' => '+51 912 345 678'],
            ['name' => 'Philippines', 'code' => 'PH', 'phone_code' => '63', 'phone_format' => '+63 905 123 4567'],
            ['name' => 'Pitcairn', 'code' => 'PN', 'phone_code' => '64', 'phone_format' => '+64 21 123 4567'],
            ['name' => 'Poland', 'code' => 'PL', 'phone_code' => '48', 'phone_format' => '+48 512 345 678'],
            ['name' => 'Portugal', 'code' => 'PT', 'phone_code' => '351', 'phone_format' => '+351 912 345 678'],
            ['name' => 'Puerto Rico', 'code' => 'PR', 'phone_code' => '1787', 'phone_format' => '+1 787 234 5678'],
            ['name' => 'Qatar', 'code' => 'QA', 'phone_code' => '974', 'phone_format' => '+974 3312 3456'],
            ['name' => 'Réunion', 'code' => 'RE', 'phone_code' => '262', 'phone_format' => '+262 692 12 34 56'],
            ['name' => 'Romania', 'code' => 'RO', 'phone_code' => '40', 'phone_format' => '+40 712 345 678'],
            ['name' => 'Russian Federation', 'code' => 'RU', 'phone_code' => '7', 'phone_format' => '+7 912 345-67-89'],
            ['name' => 'Rwanda', 'code' => 'RW', 'phone_code' => '250', 'phone_format' => '+250 781 234 567'],
            ['name' => 'Saint Barthélemy', 'code' => 'BL', 'phone_code' => '590', 'phone_format' => '+590 690 12 34 56'],
            ['name' => 'Saint Helena, Ascension and Tristan da Cunha', 'code' => 'SH', 'phone_code' => '290', 'phone_format' => '+290 51234'],
            ['name' => 'Saint Kitts and Nevis', 'code' => 'KN', 'phone_code' => '1869', 'phone_format' => '+1 869 765 2917'],
            ['name' => 'Saint Lucia', 'code' => 'LC', 'phone_code' => '1758', 'phone_format' => '+1 758 284 5678'],
            ['name' => 'Saint Martin (French part)', 'code' => 'MF', 'phone_code' => '590', 'phone_format' => '+590 690 12 34 56'],
            ['name' => 'Saint Pierre and Miquelon', 'code' => 'PM', 'phone_code' => '508', 'phone_format' => '+508 55 12 34'],
            ['name' => 'Saint Vincent and the Grenadines', 'code' => 'VC', 'phone_code' => '1784', 'phone_format' => '+1 784 430 1234'],
            ['name' => 'Samoa', 'code' => 'WS', 'phone_code' => '685', 'phone_format' => '+685 72 12345'],
            ['name' => 'San Marino', 'code' => 'SM', 'phone_code' => '378', 'phone_format' => '+378 66 12 12 12'],
            ['name' => 'Sao Tome and Principe', 'code' => 'ST', 'phone_code' => '239', 'phone_format' => '+239 981 2345'],
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'phone_code' => '966', 'phone_format' => '+966 51 234 5678'],
            ['name' => 'Senegal', 'code' => 'SN', 'phone_code' => '221', 'phone_format' => '+221 70 123 45 67'],
            ['name' => 'Serbia', 'code' => 'RS', 'phone_code' => '381', 'phone_format' => '+381 60 1234567'],
            ['name' => 'Seychelles', 'code' => 'SC', 'phone_code' => '248', 'phone_format' => '+248 2 510 123'],
            ['name' => 'Sierra Leone', 'code' => 'SL', 'phone_code' => '232', 'phone_format' => '+232 76 123456'],
            ['name' => 'Singapore', 'code' => 'SG', 'phone_code' => '65', 'phone_format' => '+65 8123 4567'],
            ['name' => 'Sint Maarten (Dutch part)', 'code' => 'SX', 'phone_code' => '1721', 'phone_format' => '+1 721 520 5678'],
            ['name' => 'Slovakia', 'code' => 'SK', 'phone_code' => '421', 'phone_format' => '+421 912 123 456'],
            ['name' => 'Slovenia', 'code' => 'SI', 'phone_code' => '386', 'phone_format' => '+386 31 234 567'],
            ['name' => 'Solomon Islands', 'code' => 'SB', 'phone_code' => '677', 'phone_format' => '+677 74 12345'],
            ['name' => 'Somalia', 'code' => 'SO', 'phone_code' => '252', 'phone_format' => '+252 71 123 4567'],
            ['name' => 'South Africa', 'code' => 'ZA', 'phone_code' => '27', 'phone_format' => '+27 71 123 4567'],
            ['name' => 'South Georgia and the South Sandwich Islands', 'code' => 'GS', 'phone_code' => '500', 'phone_format' => '+500 71234'],
            ['name' => 'South Sudan', 'code' => 'SS', 'phone_code' => '211', 'phone_format' => '+211 977 123 456'],
            ['name' => 'Spain', 'code' => 'ES', 'phone_code' => '34', 'phone_format' => '+34 612 34 56 78'],
            ['name' => 'Sri Lanka', 'code' => 'LK', 'phone_code' => '94', 'phone_format' => '+94 71 234 5678'],
            ['name' => 'Sudan', 'code' => 'SD', 'phone_code' => '249', 'phone_format' => '+249 91 123 4567'],
            ['name' => 'Suriname', 'code' => 'SR', 'phone_code' => '597', 'phone_format' => '+597 741 2345'],
            ['name' => 'Svalbard and Jan Mayen', 'code' => 'SJ', 'phone_code' => '47', 'phone_format' => '+47 412 34 567'],
            ['name' => 'Swaziland', 'code' => 'SZ', 'phone_code' => '268', 'phone_format' => '+268 7612 3456'],
            ['name' => 'Sweden', 'code' => 'SE', 'phone_code' => '46', 'phone_format' => '+46 70 123 45 67'],
            ['name' => 'Switzerland', 'code' => 'CH', 'phone_code' => '41', 'phone_format' => '+41 78 123 45 67'],
            ['name' => 'Syrian Arab Republic', 'code' => 'SY', 'phone_code' => '963', 'phone_format' => '+963 944 567 890'],
            ['name' => 'Taiwan', 'code' => 'TW', 'phone_code' => '886', 'phone_format' => '+886 912 345 678'],
            ['name' => 'Tajikistan', 'code' => 'TJ', 'phone_code' => '992', 'phone_format' => '+992 917 123 456'],
            ['name' => 'Tanzania, United Republic of', 'code' => 'TZ', 'phone_code' => '255', 'phone_format' => '+255 621 234 567'],
            ['name' => 'Thailand', 'code' => 'TH', 'phone_code' => '66', 'phone_format' => '+66 8 1234 5678'],
            ['name' => 'Timor-Leste', 'code' => 'TL', 'phone_code' => '670', 'phone_format' => '+670 7723 4567'],
            ['name' => 'Togo', 'code' => 'TG', 'phone_code' => '228', 'phone_format' => '+228 90 12 34 56'],
            ['name' => 'Tokelau', 'code' => 'TK', 'phone_code' => '690', 'phone_format' => '+690 3 1234'],
            ['name' => 'Tonga', 'code' => 'TO', 'phone_code' => '676', 'phone_format' => '+676 771 2345'],
            ['name' => 'Trinidad and Tobago', 'code' => 'TT', 'phone_code' => '1868', 'phone_format' => '+1 868 291 1234'],
            ['name' => 'Tunisia', 'code' => 'TN', 'phone_code' => '216', 'phone_format' => '+216 20 123 456'],
            ['name' => 'Turkey', 'code' => 'TR', 'phone_code' => '90', 'phone_format' => '+90 501 234 56 78'],
            ['name' => 'Turkmenistan', 'code' => 'TM', 'phone_code' => '993', 'phone_format' => '+993 65 123456'],
            ['name' => 'Turks and Caicos Islands', 'code' => 'TC', 'phone_code' => '1649', 'phone_format' => '+1 649 231 1234'],
            ['name' => 'Tuvalu', 'code' => 'TV', 'phone_code' => '688', 'phone_format' => '+688 90 1234'],
            ['name' => 'Uganda', 'code' => 'UG', 'phone_code' => '256', 'phone_format' => '+256 712 345678'],
            ['name' => 'Ukraine', 'code' => 'UA', 'phone_code' => '380', 'phone_format' => '+380 50 123 4567'],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'phone_code' => '971', 'phone_format' => '+971 50 123 4567'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'phone_code' => '44', 'phone_format' => '+44 7400 123456'],
            ['name' => 'United States', 'code' => 'US', 'phone_code' => '1', 'phone_format' => '+1 201 555 0123'],
            ['name' => 'United States Minor Outlying Islands', 'code' => 'UM', 'phone_code' => '1', 'phone_format' => '+1 201 555 0123'],
            ['name' => 'Uruguay', 'code' => 'UY', 'phone_code' => '598', 'phone_format' => '+598 94 231 234'],
            ['name' => 'Uzbekistan', 'code' => 'UZ', 'phone_code' => '998', 'phone_format' => '+998 90 123 45 67'],
            ['name' => 'Vanuatu', 'code' => 'VU', 'phone_code' => '678', 'phone_format' => '+678 591 2345'],
            ['name' => 'Venezuela, Bolivarian Republic of', 'code' => 'VE', 'phone_code' => '58', 'phone_format' => '+58 412 1234567'],
            ['name' => 'Viet Nam', 'code' => 'VN', 'phone_code' => '84', 'phone_format' => '+84 91 234 56 78'],
            ['name' => 'Virgin Islands, British', 'code' => 'VG', 'phone_code' => '1284', 'phone_format' => '+1 284 300 1234'],
            ['name' => 'Virgin Islands, U.S.', 'code' => 'VI', 'phone_code' => '1340', 'phone_format' => '+1 340 642 1234'],
            ['name' => 'Wallis and Futuna', 'code' => 'WF', 'phone_code' => '681', 'phone_format' => '+681 50 12 34'],
            ['name' => 'Western Sahara', 'code' => 'EH', 'phone_code' => '212', 'phone_format' => '+212 6-1234-5678'],
            ['name' => 'Yemen', 'code' => 'YE', 'phone_code' => '967', 'phone_format' => '+967 712 345 678'],
            ['name' => 'Zambia', 'code' => 'ZM', 'phone_code' => '260', 'phone_format' => '+260 95 1234567'],
            ['name' => 'Zimbabwe', 'code' => 'ZW', 'phone_code' => '263', 'phone_format' => '+263 71 234 5678'],
        ];

        // Add created_at and updated_at timestamps
        $now = now();
        foreach ($countries as &$country) {
            $country['created_at'] = $now;
            $country['updated_at'] = $now;
        }

        // Insert in chunks to avoid potential issues with large datasets
        foreach (array_chunk($countries, 50) as $chunk) {
            DB::table('countries')->insert($chunk);
        }
    }
}
