<?php
/**
 * @author Alexandre Possebon <dompossebon@gmail.com>
 * @contact <55 48 998483347>
 * @copyright
 */

namespace App\Http\Controllers;

use App\Model\Game;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FootballController extends Controller
{
    /**
     * Display a listing of the games.
     * @param $withDate
     * @param $personal
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index($withDate = false, $personal = false)
    {
        try {
            $check = Game::where('user_id', Auth::user()->getAuthIdentifier())->first();
            $games_saved = [];
            $response = [];
            $destination = 'personalselection';
            if ($check) {
                $gamess = json_decode($check['game']);
                if (!$personal) {
                    foreach ($gamess as $keyx => $value) {
                        $games_saved[] = $value->id;
                    }
                } else {
                    $games_saved = json_decode($check['game']);
                }
            }

            if (!$personal) {
                $destination = 'home';
                $dateEnd = '2022-07-27';
                $dateStart = date("Y-m-d");
                if ($withDate) {
                    $withDate = "?dateFrom=$dateStart&dateTo=$dateEnd";
                }

                $baseUrl = 'https://api.football-data.org';
                $client = new Client([
                    'base_uri' => $baseUrl,
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-Auth-Token' => '06b19bc26575430bb658c7a2d6899572'
                    ]
                ]);
                $getResponse = $client->get("/v4/competitions/CL/matches$withDate");
                $response = json_decode($getResponse->getBody()->getContents());
            }

            return view($destination, ['personal' => $personal, 'games_saved' => $games_saved, 'response' => $response]
            );
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Store a newly created game in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $check = Game::where('user_id', Auth::user()->getAuthIdentifier())->first();
            $game = $request['game'];
            if ($check) {
                $var1 = json_decode($check['game']);
                $var2 = json_decode($game);

                foreach ($var1 as $k => $v) {
                    if ($v->id === $var2[0]->id) {
                        throw new Exception();
                    }
                }

                $game = json_encode(array_merge($var1, $var2));
                $check->update(['game' => $game]);
            } else {
                $addEmployee = new Game();
                $addEmployee->user_id = Auth::user()->getAuthIdentifier();
                $addEmployee->game = $game;
                $addEmployee->save();
            }

            return Redirect::back()->withErrors(
                ['msgSuccess' => 'Congratulations, a new game has been successfully stored!!!']
            );
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['msgErro' => 'Attention, you already have this game stored!']);
        }
    }


    /**
     * Remove the specified game from storage.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $check = Game::where('user_id', Auth::user()->getAuthIdentifier())->first();
            $listGames = json_decode($check['game']);

            foreach ($listGames as $k => $val) {
                if ($val->id == $id) {
                    unset($listGames[$k]);
                    $listGames = array_values($listGames);
                }
            }

            $game = json_encode($listGames);
            $check->update(['game' => $game]);

            return Redirect::back()->withErrors(['msgSuccess' => 'Congratulations, Successfully Removed!!!']);
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['msgErro' => 'Attention, Not Removed! check!!!']);
        }
    }
}
