<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $title
 * @property string $description
 * @property string $category
 */
class Post extends Model
{
    //
    protected $table = "post";

    protected $attributes = [

    ];
}
