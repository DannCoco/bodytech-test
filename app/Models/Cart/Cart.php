<?php

namespace App\Models\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subtotal', 'total', 'state', 'user_id'];

    /**
     * Get the details for the cart.
     */
    public function detail()
    {
        return $this->hasMany(CartDetail::class);
    }
}
