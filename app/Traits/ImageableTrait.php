<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Storage;
use URL;

trait ImageableTrait
{

    protected $image_name;

    /**
     * Saving image to path
     *
     * @param $image_source
     * @param $attribute_name
     * @param $format
     * @return string
     */
    public function setImage($image_source, $attribute_name, $format = 'jpg')
    {
        if (empty($image_source) || empty($attribute_name)) {
            return false;
        }

        $filename = md5(uniqid()) . '.' . $format;
        $save_path = '/images/' . $filename;

        Image::make($image_source->getRealPath())->save(public_path() . $save_path);

        $this->attributes[$attribute_name] = $save_path;
        $this->image_name = $filename;

        return $this->attributes[$attribute_name];
    }


    /**
     * @param $image_source
     */
    public function deleteImage($image_source)
    {
        if (file_exists('.'. $image_source)) {
            unlink('.' .$image_source);
        }
    }


    /**
     * Return image source
     *
     * @param $attribute_name
     * @return bool|string
     */
    public function getImageSource($attribute_name = null)
    {
        return ($this->{$attribute_name}) ? URL::to($this->{$attribute_name}) : '';
    }

}