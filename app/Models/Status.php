<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use Notifiable;

    protected $table = 'status';
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
    
    public function milestones(){
        return $this->hasMany('App\Models\Item', 'status_id', 'status_id')->orderBy('item_priority', 'desc')->with('item');
    }

    /**
     * User defined methods
     *
     * @var array
     */
    public function status($user_id){
        return $this->with(['milestones' => function($query) use($user_id){
            $query->where('user_id', $user_id);
        }])->get();
    }

}
