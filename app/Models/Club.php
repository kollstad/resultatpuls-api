<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Club extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name','short_name','district_id','wa_code','org_no'];

    // app/Models/Club.php
    public function district(){ return $this->belongsTo(\App\Models\District::class); }

}

