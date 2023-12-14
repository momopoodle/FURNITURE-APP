<?php

namespace App\Models;

use Attribute;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute as CastsAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $guarded=[];
    public function formatted_amount()
    {
        return 'RS'. $this->price/100;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function setNameAttribute($value){
        $this->attributes['name']=$value;
        $this->attributes['slug']=str()->slug($value);
    }
    
    public function setPriceCastsAttribute($value){
        $this->attributes['price']=$value*100;
    }
    public function getPriceCastsAttribute($value){
        return $value/100;
    }
  
  
}
