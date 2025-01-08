<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
    protected $fillable = ['business_id', 'type', 'details'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
