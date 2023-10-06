<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','property_type_id','county','country','town','description','address','image_full','image_thumbnail','latitude','longitude','num_bedrooms','num_bathrooms','price','type','property_type'];
}
