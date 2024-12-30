<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Investment;
use App\Models\Meeting;
use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegisteredMeetings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'meeting_id',  
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function meetings(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }
    
}
