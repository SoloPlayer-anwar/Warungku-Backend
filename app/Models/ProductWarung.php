<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWarung extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_warung',
        'alamat_warung',
        'lat',
        'long',
        'photo_warung'
    ];


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }

    public function getPhotoWarungAttribute($value)
    {
        return env('ASSET_URL'). "/uploads/".$value;
    }

}
