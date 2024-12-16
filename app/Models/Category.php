<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}