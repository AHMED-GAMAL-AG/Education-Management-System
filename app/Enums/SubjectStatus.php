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

    /**
     * Get a random value from the SubjectStatus enum.
     *
     * @return string The randomly selected SubjectStatus value.
     */
    public static function getRandomValue(): SubjectStatus
    {
        return match (rand(0, 3)) {
            0 => self::Draft,
            1 => self::Reviewing,
            2 => self::Published,
            default => self::Rejected,
        };
    }
}
