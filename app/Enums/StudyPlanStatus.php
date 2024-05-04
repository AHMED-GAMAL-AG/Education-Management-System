<?php

namespace App\Enums;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum StudyPlanStatus: string implements HasLabel, HasDescription
{
    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Rejected = 'rejected';

    /**
     * Get the label of the study plan status.
     *
     * @return string|null The label of the study plan status.
     */
    public function getLabel(): ?string
    {
        return $this->name;
    }

    /**
     * Get the description of the study plan status.
     *
     * @return string|null The description of the study plan status.
     */
    public function getDescription(): ?string
    {
        return match ($this) {
            self::Draft => 'This has not finished being written yet.',
            self::Reviewing => 'This is ready for a staff member to read.',
            self::Published => 'This has been approved by a staff member and is public on the website.',
            self::Rejected => 'A staff member has decided this is not appropriate for the website.',
        };
    }
}
