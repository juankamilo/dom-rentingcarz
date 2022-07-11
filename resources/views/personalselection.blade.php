@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
                    @if(isset($errors) && key($errors->getMessages()) == 'msgErro')
                        <nav class="navbar navbar-dark bg-warning">
                            <!-- Navbar content --><h4>{{$errors->first()}}</h4>
                        </nav>
                    @elseif(isset($errors) && key($errors->getMessages()) == 'msgSuccess')
                        <nav class="navbar navbar-dark bg-success">
                            <!-- Navbar content --><h4>{{$errors->first()}}</h4>
                        </nav>
                    @endif
                <div class="card-header">
                    <h1>Your Personal Selection - Season 2022</h1>
                    <h2>Total of {{count($games_saved)}} games
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{url('index')}}">All games this season</a>
                        |
                    <a href="{{url('index/1')}}">Upcoming Games from this date (today)</a>
                        |
                    <a href="{{url('index/0/1')}}">Your Personal Selection</a>
                </div>
                <div>
                        <ul>
                            @foreach ($games_saved as $key => $body)
                                <form method="post" action="/savegame">
                                    @csrf
                                    <li>
                                        <b>Day/Hour:</b> {{ $dategame = $body->dategame }}
                                        -
                                        <a href="../../destroy/{{$body->id}}">Remove this game from the Personal Team</a>

                                    <li><b>Status:</b> {{ $status = $body->status }}</li>
                                    <li><b>stage:</b> {{ $stage = $body->stage }}</li>
                                    <li><b>Home Team:</b> {{ $team_home = $body->home_team }}</li>
                                    <li><b>Away Team:</b> {{ $team_away = $body->away_team }}</li>
                                    <li><b>Winner:</b> {{ $winner =  $body->winner }}</li>
                                    <p>

                                        <input type="hidden" name="game" value="{{ json_encode([
                                                                                                ['id'=>$body->id,
                                                                                                'stage'=>$stage,
                                                                                                'status'=>$status,
                                                                                                'winner'=>$winner,
                                                                                                'dategame'=>$dategame,
                                                                                                'away_team'=>$team_away,
                                                                                                'home_team'=>$team_home]
                                                                                                ]) }}">
                                </form>
                            @endforeach
                        </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
@endsection
