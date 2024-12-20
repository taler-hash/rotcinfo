<?php

namespace App\Models;

use App\Casts\CLCasts;
use Illuminate\Database\Eloquent\Model;

class ClassYear extends Model
{
    protected $table = 'class_years';

    protected $fillable = [
        'cl',
        'class',
        'year'
    ];

        /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cl' => CLCasts::class
        ];
    }


}
