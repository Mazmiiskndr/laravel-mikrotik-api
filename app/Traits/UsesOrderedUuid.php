<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UsesOrderedUuid
{
    /**
     * Boot the trait.
     *
     * Listen for the creating event of the model, then set the UUID.
     */
    protected static function bootUsesUuid()
    {
        static::creating(function ($model) {
            if (!isset($model->attributes['id'])) {
                $model->id = strtoupper(Str::orderedUuid());
            }
        });
    }

    /**
     * Get the casts array.
     *
     * Ensure 'id' is always cast to a string.
     *
     * @return array
     */
    public function getCasts()
    {
        return $this->casts + ['id' => 'string'];
    }
}
