<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the event associated with the appointment.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the slot associated with the appointment.
     */
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
}
