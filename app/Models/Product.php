<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
  protected $fillable = [
    'name',
    'description',
    'price',
    'quantity'
  ];

  public function casts(): array
  {
    return [
      'price' => 'decimal:2',
      'quantity' => 'integer',
    ];
  }

  public function orders(): BelongsToMany
  {
    return $this->belongsToMany(Order::class, 'order_product')->withPivot('quantity');
  }
}
