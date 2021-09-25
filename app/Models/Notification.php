<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'content',
        'type',
        'tags',
        'is_solved',
        'is_readed',
    ];

    protected $casts = [
        'tags' => 'array',
    ];
}
