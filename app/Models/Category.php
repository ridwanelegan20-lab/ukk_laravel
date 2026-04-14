<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // Relasi: Satu Kategori memiliki banyak Buku
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}