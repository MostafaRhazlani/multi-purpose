<?php

namespace App\Models;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    public function client() {
        return $this->belongsTo(Client::class);
    }
}
