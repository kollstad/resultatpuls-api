<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Discipline extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    public $incrementing = false;        // primærnøkkel er 'code' (string)
protected $keyType = 'string';
protected $fillable = ['code','name','type','unit','has_wind','is_relay','default_implement'];
protected $casts = ['has_wind'=>'bool','is_relay'=>'bool'];
}
