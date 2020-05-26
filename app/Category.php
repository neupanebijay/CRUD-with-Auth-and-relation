<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function blogs()
    {
        
        return $this->hasMany('App\Blog');

    }
    public function getNoOfBlogsAttribute(){

        /**
         * as we are in category model no need to write ('category_id',$category->id)->count(); 
         * instead 'category_id',$this->id)->count(); 
         */
        return Blog::where('category_id',$this->id)->count();
    }
}
