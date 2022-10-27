<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'image'
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk('event')->url($this->image ?? 'default-img-event.jpg'),
        );
    }

    protected function startDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->start_date) ? '' : Carbon::parse($this->start_date)->format('d/m/Y'),
        );
    }

    protected function endDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => is_null($this->end_date) ? '' : Carbon::parse($this->end_date)->format('d/m/Y'),
        );
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
