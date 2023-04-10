<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    /**
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new UserScope());
    }

    /**
     * Kategoriye bağlı ürünleri döner.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    /**
     * Kategoriye bağlı cafeleri döner.
     */
    public function cafes()
    {
        return $this->hasOne(Cafe::class, 'id', 'cafe_id');
    }
}
