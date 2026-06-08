<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database
    protected $table = 'items';

    // Mendaftarkan kolom yang boleh diisi data
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'category_id',
    ];

    // Relasi balik ke model Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}