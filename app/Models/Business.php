<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Investment;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';

    protected $fillable = [
        'title',        
        'description',
        'image_path',
    ];

    public function investors()
    {
        return $this->hasMany(Investment::class);
    }
}
