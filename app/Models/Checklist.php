<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_do_id',
        'name'
    ];

    public function todo()
    {
        return $this->belongsTo(ToDo::class);
    }
}
