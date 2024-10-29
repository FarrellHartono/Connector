<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Investment;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'user_id'
    ];

    public function investors()
    {
        return $this->hasMany(Investment::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
