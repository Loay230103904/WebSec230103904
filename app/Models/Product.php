<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ استيراد الصح

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasFactory;


    protected $fillable = ['name', 'description', 'price', 'stock', 'image'];


    public function purchases()
{
    return $this->hasMany(Purchase::class);
}

}
