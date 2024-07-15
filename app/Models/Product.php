<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount'
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
            // ->withPivot('value', 'is_winner')
            // ->withTimestamps();
    }
}
