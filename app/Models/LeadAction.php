<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAction extends Model
{
    use HasFactory;

    public const STATE_IN_PROGRESS = 'In Progress';
    public const STATE_COMPLETE = 'Complete';

    protected $fillable = [
        'lead_id',
        'action',
        'timeline',
        'state',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function isComplete(): bool
    {
        return strtolower($this->state) === 'complete';
    }
}
