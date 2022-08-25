<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $attributes = ['is_active' => 0];
    protected $guarded    = ['id'];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Contact::class);
    }
}
