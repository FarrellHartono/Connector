<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Business;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'title', 'description', 'date', 'business_id', 'meeting_link'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
