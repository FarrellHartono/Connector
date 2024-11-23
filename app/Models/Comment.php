<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'business_id', 'content', 'parent_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // A comment belongs to a business
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    // A comment may have replies
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

}
