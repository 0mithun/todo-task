<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /** @use HasFactory<\Database\Factories\TodoFactory> */
    use HasFactory;


    protected $fillable = [
        'title', 'body', 'user_id', 'status'
    ];

    protected $casts = [
        'status'    =>  'boolean'
    ];


}
