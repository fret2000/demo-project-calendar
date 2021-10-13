<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'type',
        'platform'
    ];
    const TYPES = [
        1 => 'personal',
        2 => 'room',
    ];

}
