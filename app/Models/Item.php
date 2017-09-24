<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Notifiable;

    protected $table = 'items';
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
    
    public function item(){
        return $this->hasOne('App\Models\Item', 'item_id', 'item_parent_id')->with('color')->with('subcategory')->with('category');
    }

    public function child(){
        return $this->hasMany('App\Models\Item', 'item_parent_id', 'item_id')->with(['child' => function($query){
            $query->orderBy('status_id');
        }])->with('status');
    }

    public function subcategory(){
        return $this->hasOne('App\Models\Item', 'item_id', 'item_parent_id');
    }

    public function category(){
        return $this->hasOne('App\Models\Category', 'category_id', 'category_id');
    }

    public function color(){
        return $this->hasOne('App\Models\Color', 'color_id', 'color_id');
    }

    public function status(){
        return $this->hasOne('App\Models\Status', 'status_id', 'status_id');
    }

    /**
     * User defined methods
     *
     * @var array
     */
    public function milestoneWithDetail($item_id){
        return $this->where('item_id', $item_id)->with('item')->with('status')->first();
    }

    public function itemWithChild($item_id){
        return $this->where('item_id', $item_id)->with(['child' => function($query){
            $query->orderBy('status_id');
        }])->first();
    }

    public function countByStatus($item_id, $type_id){
        return $this->select('status_id', \DB::raw('count(status_id) as total'))->where('item_parent_id', $item_id)->groupBy('status_id')->orderBy('status_id')->get();
    }

    public function milestonesPointSumByStatus($item_id){
        return $this->select('status_id', \DB::raw('sum(item_point) as total'))->where('item_parent_id', $item_id)->groupBy('status_id')->orderBy('status_id')->get();
    }

    public function subcategoriesByUserID($user_id){
        return $this->where('user_id', $user_id)->where('type_id', 3)->with('category')->get();
    }

}
