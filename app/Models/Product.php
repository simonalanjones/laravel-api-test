<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $with = ['notes','user'];

    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'description', 'price'
    ];

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }
}
