<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Cadet;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;


    protected $appends = [
        'lastname',
        'firstname'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'position',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getLastnameAttribute() {
        $name = explode(',' ,$this->attributes['name']);
        if(empty($name)) return '';
        return  $name[0];
    }

    public function getFirstnameAttribute() {
        $name = explode(',' ,$this->attributes['name']);
        if(count($name) === 1) return '';
        $sanitized = preg_replace('/\s/', '', $name[1], 1);
        return  $sanitized;
    }

    public function scopeS1Admin($q) {
        return $q->where('name', '!=' ,'admin');
    }

    public function cadet() {
        return $this->hasOne(Cadet::class, 'id_number', 'username');
    }
}