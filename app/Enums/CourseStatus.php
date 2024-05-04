<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum CourseStatus: string implements HasColor
{
    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Rejected = 'rejected';

    /**
     * Get the color associated with the course status.
     *
     * @return string|array|null The color associated with the course status.
     */
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Reviewing => 'warning',
            self::Published => 'success',
            self::Rejected => 'danger',
        };
    }
}
