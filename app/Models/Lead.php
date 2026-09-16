<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lead extends Model
{
    use HasFactory;

    public const TYPE_INVESTOR = 'investor';
    public const TYPE_STARTUP = 'startup';

    public const SUBTYPES = [
        self::TYPE_INVESTOR => [
            'corporate' => 'Corporate',
            'msme' => 'MSME',
            'family_office' => 'Family Office',
            'hni' => 'HNI',
        ],
        self::TYPE_STARTUP => [
            'msme_startup' => 'MSME Startup',
            'newway_startup' => 'Newway Startup',
        ],
    ];

    protected $fillable = [
        'type',
        'sub_type',
        'name',
        'email',
        'mobile_no',
        'company',
        'information',
        'source',
    ];

    public function actions(): HasMany
    {
        return $this->hasMany(LeadAction::class)->orderBy('id', 'desc');
    }

    public function latestAction(): HasOne
    {
        return $this->hasOne(LeadAction::class)->latestOfMany();
    }

    public static function subtypesFor(?string $type): array
    {
        if (! $type || ! isset(self::SUBTYPES[$type])) {
            return [];
        }

        return self::SUBTYPES[$type];
    }

    public function getFormattedTypeAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_INVESTOR => 'Investor',
            self::TYPE_STARTUP => 'Startup',
            default => ucfirst((string) $this->type),
        };
    }

    public function getFormattedSubTypeAttribute(): string
    {
        $all = array_merge(self::SUBTYPES[self::TYPE_INVESTOR], self::SUBTYPES[self::TYPE_STARTUP]);

        return $all[$this->sub_type] ?? ucwords(str_replace('_', ' ', (string) $this->sub_type));
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        $term = trim($term);

        return $query->where(function (Builder $sub) use ($term): void {
            $sub->where('name', 'like', "%{$term}%")
                ->orWhere('company', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('mobile_no', 'like', "%{$term}%")
                ->orWhere('source', 'like', "%{$term}%")
                ->orWhere('information', 'like', "%{$term}%")
                ->orWhereHas('actions', function (Builder $act) use ($term): void {
                    $act->where('action', 'like', "%{$term}%");
                });
        });
    }

    public function scopeOfType(Builder $query, ?string $type): Builder
    {
        if (blank($type) || $type === 'all') {
            return $query;
        }

        return $query->where('type', $type);
    }

    public function scopeOfSubType(Builder $query, ?string $subType): Builder
    {
        if (blank($subType) || $subType === 'all') {
            return $query;
        }

        return $query->where('sub_type', $subType);
    }

    public function scopeOfState(Builder $query, ?string $state): Builder
    {
        if (blank($state) || $state === 'all') {
            return $query;
        }

        return $query->whereHas('actions', function (Builder $act) use ($state): void {
            $act->where('state', $state);
        });
    }
}
