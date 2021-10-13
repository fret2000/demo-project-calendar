<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id','name','type','platform','user_id','platform_calendar_id'];
    const TYPES = [
        1 => 'personal',
        2 => 'room',
    ];


    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function event()
    {
        return $this->hasMany(Event::class);
    }
}
