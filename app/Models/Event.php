<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = ['date_start','date_finish','title','id','calendar_id','is_accepted','is_blocking'];
    



   /* function save($data){
        $query = "INSERT INTO $this->table (id, 
        title, 
        date_start, 
        date_finish, 
        calendar_id, 
        is_accepted, 
        is_blocking) VALUES ($data['id'], 
        $data['title'], 
        $data['date_start'],
        $data['date_finish'], 
        $data['calendar_id'],
        $data['is_accepted'],
        $data['is_blocking'])";
        
    }*/


    

}
