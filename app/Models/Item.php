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

    public function subcategory(){
        return $this->hasOne('App\Models\Item', 'item_id', 'item_parent_id');
    }

    public function category(){
        return $this->hasOne('App\Models\Category', 'category_id', 'category_id');
    }

    public function color(){
        return $this->hasOne('App\Models\Color', 'color_id', 'color_id');
    }

    /**
     * User defined methods
     *
     * @var array
     */
    public function milestoneWithDetail($item_id){
        return $this->where('item_id', $item_id)->with('item')->first();
    }

}
