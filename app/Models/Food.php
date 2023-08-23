<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'type',
        'status',
    ];

    /**
     * RELATIONSHIPS
     */

    /**
     * user() relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * acceptedByUser() relationship
     */
    public function acceptedByUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'food_user')
            ->withPivot('collection_time')
            ->withTimestamps();
    }
}
