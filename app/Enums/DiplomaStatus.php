<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;

enum DiplomaStatus: string implements HasIcon
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
}
