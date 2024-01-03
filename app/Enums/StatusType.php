<?php

namespace App\Enums;

enum StatusType: int {
    case SCHEDULED = 1;
    case CONFIRMED = 2;
    case CANCELLED = 3;

    public function color(): string
    {
        return match($this) {
            StatusType::SCHEDULED => 'primary',
            StatusType::CONFIRMED => 'success',
            StatusType::CANCELLED => 'danger',
        };
    }
}


?>
