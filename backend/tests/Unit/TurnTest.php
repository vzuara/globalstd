<?php

namespace Tests\Unit;

use App\Models\Turn;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Http\Requests\CreateTurnRequest;
use App\Http\Requests\UpdateTurnRequest;
use Illuminate\Http\Request;

use App\Services\TurnService;

class TurnTest extends TestCase
{
    use RefreshDatabase;

   
    public function test_should_show_a_list_of_turns()
    {
        $turnService = new TurnService();
        Turn::factory()->count(5)->create();

        $request = new Request();

        $turns = $turnService->getTurns($request);
        
        $this->assertArrayHasKey('count', $turns);
        $this->assertArrayHasKey('data', $turns);
        $this->assertCount(5, $turns['data']);
        $this->assertEquals(5, $turns['count']);
    }

    public function test_should_show_a_turn()
    {
        $turnService = new TurnService();
        $turn = Turn::factory()->create();

        $newTurn = $turnService->getTurn($turn->id);
        
        $this->assertNotNull($newTurn);
    }

    public function test_should_store_a_turn()
    {
        $turnService = new TurnService();
        $request = new CreateTurnRequest();

        $request->merge([
            'turn' => '10:10',
            'status' => true
        ]);

        $turn = $turnService->storeTurn($request);
        
        $this->assertDatabaseHas('turns', [
            'turn' => $turn->turn,
            'status' => $turn->status
        ]);
    }

    public function test_should_update_a_turn()
    {
        $turnService = new TurnService();
        $request = new UpdateTurnRequest();

        $turn = Turn::factory()->create();

        $request->merge([
            'turn' => '10:10',
            'status' => true
        ]);

        $turnUpdated = $turnService->updateTurn($request, $turn->id);
        
        $this->assertDatabaseHas('turns', [
            'turn' => $turnUpdated->turn,
            'status' => $turnUpdated->status
        ]);
    }
}
