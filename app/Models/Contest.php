<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'entry_fee', 'total_slots', 'occupied_slots']; // Assurez-vous que ces champs sont remplis

    public function images()
    {
        return $this->hasMany(ContestImage::class);
    }

    public function prizes()
    {
        return $this->hasMany(Prize::class);
    }

    // Méthode pour vérifier si des places sont disponibles
    public function hasAvailableSlots()
    {
        return $this->occupied_slots < $this->total_slots;
    }

    // Méthode pour réserver une place
    public function reserveSlot()
    {
        if ($this->hasAvailableSlots()) {
            $this->increment('occupied_slots');
            return true;
        }
        return false;
    }
}
