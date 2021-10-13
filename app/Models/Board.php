<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get all of the labels for the Board
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function labels(): HasMany
    {
        return $this->hasMany(Label::class, 'board_id');
    }

    /**
     * Get all of the tasks for the Board
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'board_id');
    }
}
