<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnosticItem extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'stress_diagnostic_id',
        'stress_event_id',
        'score',
    ];

    /**
     * @return BelongsTo
     */
    public function diagnostic(): BelongsTo
    {
        return $this->belongsTo(\App\Models\StressDiagnostic::class, 'stress_diagnostic_id');
    }

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(\App\Models\StressEvent::class, 'stress_event_id');
    }
}
