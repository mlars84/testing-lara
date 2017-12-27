<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'roster'];

    public function add($players)
    {
        // add a guard
        $this->guardAgainstTooManyMembers($this->extractNewPlayersCount($players));

        $method = $players instanceof Player ? 'save' : 'saveMany';

        $this->members()->$method($players);
    }

    public function members()
    {
        return $this->hasMany(PLayer::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    public function maximumSize()
    {
        return $this->roster;
    }

    protected function guardAgainstTooManyMembers($newPlayersCount)
    {
        $newTeamCount = $this->count() + $newPlayersCount;
        
        if ($newTeamCount > $this->maximumSize()) {
            throw new \Exception('This exceeds the maximum roster size!');
        }
    }

    protected function extractNewPlayersCount($players)
    {
        return ($players instanceof Player) ? 1 : count($players);
    }

    public function removePlayer($members = null)
    {
        if ($members instanceof Player) {
            return $members->leaveTeam();
        }

        $members->each(function($player) {
            $player->leaveTeam();
        });

        //51-53 could be refactored to
        // $this->players()
        //      ->whereIn('id', $players->pluck('id'))
        //      ->update(['team_id' => null]);
    } 

    public function restart()
    {
        return $this->members()->update(['team_id' => null]);
    }

    public function removeAllPlayers(Players $players)
    {
        $this->members['team_id'] = null;

    }
} 
