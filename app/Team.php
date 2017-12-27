<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'roster'];

    public function add($players)
    {
        // add a guard
        $this->guardAgainstTooManyMembers($players);

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

    protected function guardAgainstTooManyMembers($players)
    {
        $numUsersToAdd  = ($players instanceof Player) ? 1 : $players->count();

        $newTeamCount = $this->count() + $numUsersToAdd;
        
        if ($newTeamCount > $this->roster) {
            throw new \Exception('This exceeds the maximum roster size!');
        }
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
