<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    use HasFactory;

    protected $fillable = ['contest_id', 'name', 'amount'];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }
}
