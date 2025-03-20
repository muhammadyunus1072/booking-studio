<?php

namespace App\Models\MasterData;

use App\Helpers\FilePathHelper;
use App\Models\MasterData\Studio;
use Sis\TrackHistory\HasTrackHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\MasterData\ProductBookingTime;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasTrackHistory;

    protected $fillable = [
        'studio_id',
        'name',
        'description',
        'price',
        'image',
        'note',
    ];
    
    protected $guarded = ['id'];

    public function isDeletable()
    {
        return true;
    }

    public function isEditable()
    {
        return true;
    }

    public function saveInfo($object, $data = null, $prefix = "product")
    {
        if($data)
        {
            foreach($data as $item)
            {
                $object[$prefix . "_".$item] = $this->$item;
            }
        }else{
            $object[$prefix . "_studio_id"] = $this->studio_id;
            $object[$prefix . "_name"] = $this->name;
            $object[$prefix . "_description"] = $this->description;
            $object[$prefix . "_price"] = $this->price;
            $object[$prefix . "_image"] = $this->image;
            $object[$prefix . "_note"] = $this->note;
        }

        return $object;
    }

    public function image_url()
    {
        return $this->image ? Storage::url(FilePathHelper::FILE_PRODUCT_IMAGE . $this->image) : null;
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class, 'studio_id', 'id');
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'product_id', 'id');
    }

    public function productBookingTimes()
    {
        return $this->hasMany(ProductBookingTime::class, 'product_id', 'id');
    }
}
