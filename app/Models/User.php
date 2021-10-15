<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['id' , 'name', 'original_id', 'created_at', 'updated_at'];

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }
}
