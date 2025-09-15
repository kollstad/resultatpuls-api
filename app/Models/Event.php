<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Event extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
    'name','type','start_date','end_date','city','venue','sanction_level','course_cert','elevation_gain'
];
protected $casts = [
    'start_date'=>'date',
    'end_date'=>'date',
    'elevation_gain'=>'integer',
];
}
