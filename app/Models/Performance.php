<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Performance extends Model
{
    use HasFactory, HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
    'event_discipline_id','athlete_id','relay_team_id','mark_raw','mark_display','unit',
    'position','wind','status','is_legal','splits_json','device_meta_json',
    'version_group_id','is_current','submitted_by','submitted_at','signature_id','hash'
];
    protected $casts = [
        'position'=>'integer',
        'wind'=>'decimal:1',
        'is_legal'=>'bool',
        'is_current'=>'bool',
        'splits_json'=>'array',
        'device_meta_json'=>'array',
        'submitted_at'=>'datetime',
    ];
    public function eventDiscipline(){ return $this->belongsTo(\App\Models\EventDiscipline::class); }
}
