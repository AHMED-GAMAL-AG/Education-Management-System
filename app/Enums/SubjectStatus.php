<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SubjectStatus: string implements HasLabel
{
    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Rejected = 'rejected';

    /**
     * Get the label for the subject status.
     *
     * @return string|null The label for the subject status.
     */
    public function getLabel(): ?string
    {
        return $this->name;
    }

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
