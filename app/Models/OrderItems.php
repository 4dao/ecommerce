<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
