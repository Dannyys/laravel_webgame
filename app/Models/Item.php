<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_item');
    }

    public function calculateValue(){
        $modifier = ($this->value_mod/100) * $this->base_value;
        return (int)round($modifier + $this->base_value);
    }
}
