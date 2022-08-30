<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'product_id', 'price', 'supposed_return_date', 'returned', 'returned_date' ];

    /**
     * Rent - Product relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}