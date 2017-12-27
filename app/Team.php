<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'roster'];

    public function add($player)
    {
        // add a guard
        $this->guardAgainstTooManyMembers();

        if ($player instanceof Player) {
            return $this->players()->save($player);
        }

        $this->players()->saveMany($player);

        //could also refactor 16-20 to:
        // $method = $player instanceof Player ? 'save' : 'saveMany';

        // $this->players()->$method($player);
    }

    public function players()
    {
        return $this->hasMany(PLayer::class);
    }

    public function count()
    {
        return $this->players()->count();
    }

    protected function guardAgainstTooManyMembers()
    {
        if ($this->count() >= $this->roster) {
            throw new \Exception('This exceeds the maximum roster size!');
        }
    }

    public function removePlayer($players = null)
    {
        if ($players instanceof Player) {
            return $players->leaveTeam();
        }

        $players->each(function($player) {
            $player->leaveTeam();
        });

        //51-53 could be refactored to
        // $this->players()
        //      ->whereIn('id', $players->pluck('id'))
        //      ->update(['team_id' => null]);
    } 

    public function restart()
    {
        return $this->players()->update(['team_id' => null]);
    }

    public function removeAllPlayers(Players $players)
    {
        $this->players['team_id'] = null;

    }
} 
