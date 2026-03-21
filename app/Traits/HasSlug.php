<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait for the model.
     */
    protected static function bootHasSlug()
    {
        static::saving(function ($model) {
            $slugField = $model->getSlugField();
            $sourceString = $model->{$slugField};

            if (empty($model->slug) && !empty($sourceString)) {
                $slug = Str::slug($sourceString);
                $originalSlug = $slug;
                $count = 1;

                // Check for uniqueness
                while (static::where('slug', $slug)->where('id', '!=', $model->id ?? 0)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $model->slug = $slug;
            }
        });
    }

    /**
     * Get the field to generate the slug from.
     * Models can override this. Defaults to 'title'.
     *
     * @return string
     */
    public function getSlugField(): string
    {
        return 'title';
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
