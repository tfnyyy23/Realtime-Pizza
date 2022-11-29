<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable =[
        'id_category','images_menu','name_menu','size_menu','price_menu','quantity_menu','satuan_menu'
    ];
}
