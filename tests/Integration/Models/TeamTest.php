<?php

use App\Team;
use App\Player;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    use DatabaseTransactions;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test */
    public function it_has_a_name()
    {
        $team = new Team(['name' => 'Timberwolves']);

        $this->assertEquals('Timberwolves', $team->name );
    }

    /** @test */
    public function it_can_add_players()
    {
        $team = factory(Team::class)->create();

        $player = factory(Player::class)->create();
        $player2 = factory(Player::class)->create();

        $team->add($player);
        $team->add($player2);

        $this->assertEquals(2, $team->count());
    } 

    /** @test */
    public function a_team_can_add_multiple_players_at_once()
    {
        $team = factory(Team::class)->create();

        $players = factory(PLayer::class, 2)->create();

        $team->add($players);

        $this->assertEquals(2, $team->count());
    }

    /** @test */
    public function it_has_a_maximum_size()
    {
        $team = factory(Team::class)->create(['roster' => 2]);

        $player = factory(Player::class)->create();
        $player2 = factory(Player::class)->create();

        $team->add($player);
        $team->add($player2);

        $this->assertEquals(2, $team->count());

        //expect that beyond this point an exception will be thrown 
        $this->setExpectedException('Exception');
        $player3 = factory(Player::class)->create();
        $team->add($player3);
    }

    /** @test */
    public function it_can_remove_a_player()
    {
        // GIVEN we have a team of two players
        $team = factory(Team::class)->create(['roster' => 2]);
        $players = factory(Player::class, 2)->create();
        $team->add($players);

        // WEHN we remove one player
        $team->removePlayer($players[0]);  

        // THEN the count should be 1 rather than 2 
        $this->assertEquals(1, $team->count());
    }

    /** @test */
    public function it_can_remove_all_players_at_once()
    {
        // GIVEN we have two players
        $team = factory(Team::class)->create(['roster' => 2]);
        $players = factory(Player::class, 2)->create();
        $team->add($players);  

        // WHEN we remove all players
        $team->removePlayer();

        // THEN the count should be 0 rather than 2
        $this->assertEquals(0, $team->count());
    }

    /** @test */
    public function a_team_can_remove_more_than_one_method_at_once()
    {
        // GIVEN
        $team = factory(Team::class)->create(['roster' => 3]);
        $players = factory(Player::class, 3)->create();
        $team->add($players);

        // WHEN
        $team->removePlayer($players->slice(0, 2));

        // THEN
        $this->assertEquals(1, $team->count());
    }
}
