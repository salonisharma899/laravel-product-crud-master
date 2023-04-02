<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Products extends Model
{
    use SoftDeletes;
    //
    
    protected $table = "products";

    protected $fillable = [
        'id',
        'name',
        'descryption',
        'category_id',
        'price',
        'image_path',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id','id');
    }

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];  

    public function getCreatedAtAttribute()
    {
        return  isset($this->attributes['created_at']) ? Carbon::parse($this->attributes['created_at'])->format('Y-m-d g:i A') : null;
    }

    public function getUpdatedAtAttribute()
    {
        return  isset($this->attributes['updated_at']) ? Carbon::parse($this->attributes['updated_at'])->format('Y-m-d g:i A') : null;
    }

    public function getDeletedAtAttribute()
    {
        return  isset($this->attributes['deleted_at']) ? Carbon::parse($this->attributes['deleted_at'])->format('Y-m-d g:i A') : null;
    }
}
