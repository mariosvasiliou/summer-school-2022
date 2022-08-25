<?php

namespace App\Models;

use Arr;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates      = ['created_at', 'updated_at', 'deleted_at'];
    protected $guarded    = ['id'];
    protected $attributes = [
        'is_legal_entity' => 0,
        'is_client'       => 0,
        'is_user'         => 0,
    ];

    /**
     * Get the contact's full name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => (Arr::get($attributes, 'is_legal_entity',
                    0) === 0) ? $attributes['first_name'] . ' ' . $attributes['last_name'] : $attributes['legal_name'],
        );
    }

    /**
     * Get the contact's full address.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function fullAddress(): Attribute
    {
        $fullAddress = [];
        if (filled($this->attributes['street'])) {
            $fullAddress[] = $this->attributes['street'];
        }
        if (filled($this->attributes['building'])) {
            $fullAddress[] = $this->attributes['building'];
        }
        if (filled($this->attributes['postal_code'])) {
            $fullAddress[] = $this->attributes['postal_code'];
        }
        if (filled($this->attributes['city'])) {
            $fullAddress[] = $this->attributes['city'];
        }
        if (filled($this->attributes['country'])) {
            $fullAddress[] = $this->attributes['country'];
        }
        return Attribute::make(
            get: fn($value, $attributes) => implode(', ', $fullAddress)
        );
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
