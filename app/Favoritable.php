<?php

namespace App;

trait FavoriTable
{
    public static function bootFavoriTable()
    {
        static::deleting(function ($model) {
            //this is sql query = $model->favorite()->delete
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite($userId)
    {
        $attributes = ['user_id' => $userId];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite($userId)
    {
        $attributes = ['user_id' => $userId];
        $this->favorites()->where($attributes)->get()->each->delete();
    }

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
