<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'value',
        'status',
        'creator_id'
    ];
    protected $casts = [
        'end_time' => 'date:Y-m-d',
        'start_time' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
