<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Notifiable;

    protected $table = 'category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status_title', 'status_description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Relationships
     *
     * @var array
     */
    
    // public function milestones(){
    //     return $this->hasMany('App\Models\Item', 'status_id', 'status_id')->with('items')->with('category');
    // }

    /**
     * User defined methods
     *
     * @var array
     */
    // public function status(){
    //     return $this->with('milestones')->get();
    // }

}
