<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function modify($request, $index)
    {
        $url_types = config('url.types');
        $url_types[$index];
        $this->fill(['url' => $request->input($url_types[$index])])->save();
    }

    public static function make($url_type)
    {
        return self::create(
            [
                'url_type' => $url_type,
            ]
        );
    }
}
