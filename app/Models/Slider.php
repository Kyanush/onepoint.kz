<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;
use DB;
use App\Tools\UploadableTrait;

class Slider extends Model
{
    use UploadableTrait;

    protected $table = 'sliders';
    protected $fillable = [
        'name',
        'link',
        'image',
        'sort',
        'show_where',
        'created_at',
        'updated_at',
        'active'
	];

    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
        {
            $query->Where(   DB::raw('LOWER(name)'), 'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(link)'), 'like', "%"  . $search . "%");
        }
        return $query;
    }

 	public static function boot()
    {

        parent::boot();
        static::deleting(function($obj) {
            $obj->deleteImage();
        });

        //Событие до
        static::Saving(function($model){
            if(is_uploaded_file($model->image))
            {
                if($model->id)
                    self::find($model->id)->deleteImage();

                $model->image = $model->uploadFile($model->image, config('shop.sliders_path_file'));
            }
        });

    }

    public function pathImage($firstSlash = false)
    {
        if(!empty($this->image))
            return ($firstSlash ? '/' : '') . config('shop.sliders_path_file') . $this->image;
        else
            false;
    }

    public function deleteImage(){
        return File::delete($this->pathImage());
    }


}