<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $with = ['user'];

    protected $fillable = [
        'note',
        'product_id',
        'user_id'
    ];


    use HasFactory;

    public function Product() {
        return $this->belongsTo('App\Product');
    }

    public function User() {
        return $this->belongsTo(User::class);
    }

}
