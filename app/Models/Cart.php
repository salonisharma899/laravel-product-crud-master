<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Cart extends Model
{
    use SoftDeletes;
    //
    protected $table = "cart";

    protected $fillable = [
        'id',
        'selected_date',
        'category_id',
        'product_id',
        'selected_by',
        'created_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $dates = [
        'selected_date',
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
    public function getSelectedDateAttribute()
    {
        return  isset($this->attributes['selected_by']) ? Carbon::parse($this->attributes['selected_by'])->format('Y-m-d g:i A') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'selected_by','id');
    }
    public function category()
    {
        return $this->belongsTo(Categories::class,'category_id','id');
    }
    public function product()
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }
}
