<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $type = [
        0 => 'Fruit',
        1 => 'Vegetable',
    ];

    protected $fillable = [
        'name',
        'type',
        'grade_list',
    ];

}
