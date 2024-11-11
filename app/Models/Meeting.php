<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Business;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'date', 'business_id'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
