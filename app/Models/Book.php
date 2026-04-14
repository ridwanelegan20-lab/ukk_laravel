<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Saya sudah menambahkan 'year' ke dalam daftar ini:
    protected $fillable = ['title', 'author', 'category_id', 'year', 'image', 'stock'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    public function reviews() 
    {
        return $this->hasMany(Review::class);
    }

    // Fungsi canggih untuk menghitung rata-rata rating
    public function averageRating() 
    {
        return round($this->reviews()->avg('rating'), 1) ?? 0;
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}