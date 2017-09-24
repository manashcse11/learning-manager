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
        'category_title', 'category_description'
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
    
    /**
     * User defined methods
     *
     * @var array
     */
    public function allCategory(){
        return $this->where('category_status', 1)->get();
    }
    public function categoryByID($id){
        return $this->where('category_status', 1)->where('category_id', $id)->first();
    }

}
