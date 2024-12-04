<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Casts\DOBCast;

class Cadet extends Model
{
    protected $fillable = [
        'name',
        'cadet_identifier',
        'gender',
        'age',
        'dob',
        'address',
        'course',
        'religion',
        'b_type',
        'height',
        'beneficiary',
        'email',
        'subject',
        'class_year_id',
        'sem_1_grade',
        'sem_2_grade',
        'status'
    ];

    protected $appends = [
        'lastname',
        'firstname'
    ];

    protected function casts() {
        return [
            'dob' => DOBCast::class
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

    public function classyear() {
        return $this->belongsTo(ClassYear::class, 'class_year_id', 'id');
    }

    public function grades() {
        return $this->hasMany(Grade::class);
    }

    public function scopeActive($q) {
        return $q->where('status', 'active');
    }

    public function scopeInactive($q) {
        return $q->where('status', 'inactive');
    }
}