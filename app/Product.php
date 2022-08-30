<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'description', 'price', 'available', 'category_id' ];

    /**
     * Product - Category relationship
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    /**
     * Product - Rent relationship
     */
    public function rent()
    {
        return $this->hasMany(Rent::class);
    }

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}