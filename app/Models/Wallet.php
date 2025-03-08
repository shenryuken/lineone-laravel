<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_number',
        'balance',
        'currency',
        'is_verify',
        'is_default'
    ];

    protected $casts = [
        'balance' => 'integer',
        'is_verify' => 'boolean',
        'is_default' => 'boolean'
    ];

    // Accessor to convert balance from cents to dollars
    public function getBalanceInDollarsAttribute()
    {
        return number_format($this->balance / 100, 2);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

   public static function generateUniqueAccountNumber($currency)
    {
        $prefix = self::getCurrencyPrefix($currency);
        do {
            $uniquePart = mt_rand(10000000000, 99999999999); // 11 digits
            $accountNumber = $prefix . $uniquePart;
            $checkDigit = self::calculateCheckDigit($accountNumber);
            $fullAccountNumber = $accountNumber . $checkDigit;
        } while (self::where('account_number', $fullAccountNumber)->exists());

        return $fullAccountNumber;
    }

     private static function getCurrencyPrefix($currency)
    {
        $prefixes = [
            'USD' => '4000',
            'MYR' => '5000',
            // Add more currency prefixes as needed
        ];

        return $prefixes[$currency] ?? '9000'; // Default prefix for unknown currencies
    }

    private static function calculateCheckDigit($number)
    {
        $sum = 0;
        $parity = 2;
        for ($i = strlen($number) - 1; $i >= 0; $i--) {
            $digit = $number[$i];
            $product = $digit * $parity;
            $sum += $product > 9 ? $product - 9 : $product;
            $parity = 3 - $parity; // Alternates between 2 and 1
        }
        $checkDigit = (10 - ($sum % 10)) % 10;
        return $checkDigit;
    }

    public function getFormattedAccountNumberAttribute()
    {
        $number = $this->account_number;
        return implode(' ', str_split($number, 4));
    }
}
