<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public const USER = 'user';
    public const ADMIN = 'admin';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'label',
    ];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
