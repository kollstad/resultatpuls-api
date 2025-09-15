<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Athlete extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
    'sports_id','first_name','last_name','dob','gender','club_id','nationality','status'
];
protected $casts = [
    'dob' => 'date',
];

// app/Models/Athlete.php
public function club(){ return $this->belongsTo(\App\Models\Club::class); }
}


