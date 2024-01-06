<?php

namespace App\Models;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['formated_start_time', 'formated_end_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => StatusType::class
    ];

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function formatedStartTime(): Attribute {
        return Attribute::make(
            get: fn () => $this->start_time->format('Y-m-d h:i A')
        );
    }

    public function formatedEndTime(): Attribute {
        return Attribute::make(
            get: fn () => $this->end_time->format('Y-m-d h:i A')
        );
    }
}
