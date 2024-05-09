<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum DiplomaStatus: string implements HasIcon, HasColor
{
    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Rejected = 'rejected';

    /**
     * Get the icon associated with the diploma status.
     *
     * @return string|null The icon class name or null if no icon is found.
     */
    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'heroicon-m-pencil',
            self::Reviewing => 'heroicon-m-eye',
            self::Published => 'heroicon-m-check',
            self::Rejected => 'heroicon-m-x-mark',
        };
    }

    /**
     * Get the color associated with the diploma status.
     *
     * @return string|array|null The color associated with the diploma status.
     */
    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Draft => 'info',
            self::Reviewing => 'warning',
            self::Published => 'success',
            self::Rejected => 'danger',
        };
    }

    /**
     * Get a random value from the DiplomaStatus enum.
     *
     * @return string The randomly selected DiplomaStatus value.
     */
    public static function getRandomValue(): DiplomaStatus
    {
        return match (rand(0, 3)) {
            0 => self::Draft,
            1 => self::Reviewing,
            2 => self::Published,
            default => self::Rejected,
        };
    }
}
