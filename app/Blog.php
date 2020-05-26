<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    /**
     * protected fillable is done only when Blog::create etc is done in blogcontroller
     */
    // protected $fillable = ['title','description', 'user_id', 'image', 'category_id'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    // the following works when we mistakenly write $blogss instead of blog. db will make new table as $blogss and keeps the data in it
    // protected $table = $blogss;

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function getMetaDataAttribute()
    {

       return "Posted by: ".$this->user->name." ".$this->created_at->diffForHumans();
    }

    public function getCategoryNameAttribute()
    {
        // if($this->category_id == 0)
        // {
        //     return "undefined";
        // }
        // return ($this->category->name);

        return ($this->category_id == 0) ? "Undefined" : $this->category->name;

    }
// // this is to count no of blogs and show like a notification
//     public function getCountNotifyAttribute()
//     {
//        return ;
//     }
}
