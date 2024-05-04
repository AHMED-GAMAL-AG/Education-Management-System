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
}
