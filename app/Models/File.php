<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'note_id',
        'directory',
    ];

    public function note() {
        return $this->belongsTo(Note::class);
    }
}
