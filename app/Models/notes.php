<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
	 use HasFactory;
	
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','name','description'];
    


    public function user_notes()
    {
        return $this->belongsTo(User::class,'user_id');
     
    }
}
