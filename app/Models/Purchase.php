<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    const PAYMENT_METHOD_CONVENIENCE = 1;

    const PAYMENT_METHOD_CREDIT = 2;

    protected $fillable = [
        'item_id',
        'user_id',
        'post_code',
        'address',
        'building',
        'payment_method',
    ];

    public static function getPaymentMethodLabels(): array
    {
        return [
            self::PAYMENT_METHOD_CONVENIENCE => 'コンビニ払い',
            self::PAYMENT_METHOD_CREDIT => 'クレジット払い',
        ];
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
