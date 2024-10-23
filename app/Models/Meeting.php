<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Business;

class Meeting extends Model
{
    protected $fillable = ['title', 'description', 'date', 'business_id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
