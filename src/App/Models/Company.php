<?php

namespace LaravelEnso\Companies\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use LaravelEnso\Addresses\App\Traits\Addressable;
use LaravelEnso\Comments\App\Traits\Commentable;
use LaravelEnso\Discussions\App\Traits\Discussable;
use LaravelEnso\Documents\App\Traits\Documentable;
use LaravelEnso\DynamicMethods\App\Traits\Relations;
use LaravelEnso\Helpers\App\Traits\AvoidsDeletionConflicts;
use LaravelEnso\People\App\Models\Person;
use LaravelEnso\Rememberable\App\Traits\Rememberable;
use LaravelEnso\Tables\App\Traits\TableCache;
use LaravelEnso\TrackWho\App\Traits\CreatedBy;
use LaravelEnso\TrackWho\App\Traits\UpdatedBy;
use Sibtain\Classrooms\App\Models\Classroom;
use Sibtain\Teachers\App\Teacher;

class Company extends Model
{
    use Addressable, AvoidsDeletionConflicts, Commentable, CreatedBy, Discussable,
        Documentable, Relations, Rememberable, TableCache, UpdatedBy;

    protected $fillable = [
        'code','name', 'email', 'phone', 'is_tenant', 'status',
    ];

    protected $casts = ['is_tenant' => 'boolean'];

    public function people()
    {
        return $this->belongsToMany(Person::class)
            ->withPivot('position');
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function classroom()
    {
        return $this->belongsToMany(Classroom::class);
    }

    public static function owner()
    {
        return App::make(static::class)
            ->cacheGet(config('enso.config.ownerCompanyId'));
    }

    public function isTenant()
    {
        return $this->is_tenant;
    }

    public function scopeTenant($query)
    {
        $query->whereIsTenant(true);
    }

    public function mandatary()
    {
        return $this->people()
            ->withPivot('position')
            ->wherePivot('is_mandatary', true)
            ->first();
    }

    public function attachPerson(int $personId, ?string $position = null)
    {
        $this->people()->attach($personId, [
            'is_main' => false,
            'is_mandatary' => false,
            'position' => $position,
        ]);
    }

    public function updateMandatary(?int $mandataryId)
    {
        $pivotIds = $this->people->pluck('id')->reduce(fn ($pivot, $value) => $pivot
            ->put($value, ['is_mandatary' => $value === $mandataryId]), new Collection()
        )->toArray();

        $this->people()->sync($pivotIds);
    }
}
