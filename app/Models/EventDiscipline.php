<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class EventDiscipline extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
    'event_id','discipline_code','age_category','round','timing_method','implement_weight','is_team_scored'
];
protected $casts = [
    'implement_weight'=>'decimal:1',
    'is_team_scored'=>'bool',
];
public function event(){ return $this->belongsTo(\App\Models\Event::class); }
}
