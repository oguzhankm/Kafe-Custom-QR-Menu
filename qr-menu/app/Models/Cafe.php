<?php

namespace App\Models;

use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Cafe extends Model
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
     * Kafeye bağlı olan kategorileri getirir.
     * @return HasMany
     */
    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Kafeye bağlı olan tüm ürünleri döner
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, 'cafe_id', 'id');
    }


}
