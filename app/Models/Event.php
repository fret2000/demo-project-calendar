<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //Authenticatable
    use HasFactory;
    public $timestamps = false;


    const TYPES = [
        1 => 'yandex',
        2 => 'google',
    ];
    protected $fillable = ['date_start','date_finish','title','id','calendar_id','is_accepted','is_blocking'];






}
