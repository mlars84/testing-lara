<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'position', 'team_id'];

    public function leaveTeam()
    {
        $this->team_id = null;
        $this->save();     
        
        return $this;
    }
}
