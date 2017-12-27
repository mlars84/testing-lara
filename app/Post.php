<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function likes()
    {
        // morphMany: defines a polymorphic one-to-many relationship
        return $this->morphMany(Like::class, 'likeable');
    }

    public function like()
    {
        $like = new Like(['user_id' => Auth::id()]);

        $this->likes()->save();
    }

    public function unlike()
    {
        $this->likes()->where('user_id', Auth::id())->delete();
    }

    public function isLiked()
    {
        return !! $this->likes()
                    ->where('user_id', Auth::id())
                    ->count;
    }

    public function toggle()
    {
        if ($this->isLiked()) {
            return $this->unlike();
        }

        return $this->like();
    }
}
