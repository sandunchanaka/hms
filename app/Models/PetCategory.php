<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetCategory extends Model
{
    use HasFactory;

    public $table = 'pet_categories';

    public $fillable = ['name'];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
    ];

    public static $rules = [
        'name' => 'required|unique:pet_categories,name',
    ];
}