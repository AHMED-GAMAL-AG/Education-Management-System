<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DiplomaSubject extends Pivot
{
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function diploma(): BelongsTo
    {
        return $this->belongsTo(Diploma::class);
    }
}
