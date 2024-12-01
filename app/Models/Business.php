<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Investment;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Comment;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'start_date',
        'end_date',
        'nominal',
        'phone_number',
        'address',
        'status',
        'user_id'
    ];

    public function investors(): HasMany
    {
        return $this->hasMany(Investment::class);
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
}
