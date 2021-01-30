<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUrl extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function modify()
    {
        return $this->fill()->save();
    }

    public static function make($profile_id, $url_id): void
    {
        self::create(
            [
                'profile_id' => $profile_id,
                'url_id' => $url_id,
            ]
        );
    }
}
