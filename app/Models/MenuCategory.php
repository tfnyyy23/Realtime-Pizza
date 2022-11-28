<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    public $primaryKey = 'id_menu_category';
    
    protected $fillable = [
        'menu_category'
    ];
}
