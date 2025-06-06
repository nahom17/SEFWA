@extends('components.layouts.app')

@section('content')

<div>

    <style>
        /* Custom CSS for better mobile responsiveness */
@media (max-width: 760.98px) {
    .table-responsive {
        border: 0;
    }

    .table-responsive table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    .table-responsive table thead {
        display: none;
    }

    .table-responsive table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #444;
    }

    .table-responsive table td {
        display: block;
        text-align: right;
        border-bottom: 1px solid #444;
    }

    .table-responsive table td::before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }

    .table-responsive table td:last-child {
        border-bottom: 0;
    }

    .table-responsive table td .d-flex {
        flex-direction: column;
        align-items: flex-start;
    }

    .table-responsive table td img {
        margin-bottom: 5px;
    }

    .pagination .page-link {
        font-size: 14px; /* Adjust font size */
        padding: 5px 10px; /* Adjust padding */
    }
    .pagination .page-item {
        margin: 2px;
    }
}


    </style>
    
    
<!--    @php-->
    
    
<!--    $today = Carbon\Carbon::today();-->
<!--    $currentSunday = $today->isSunday() -->
<!--        ? $today -->
<!--        : $today->copy()->next(Carbon::SUNDAY);-->
        
<!--$upcomingFixtures = \App\Models\Fixture::with(['homeTeam', 'awayTeam'])-->
<!--            ->whereDate('match_date', $currentSunday)-->
<!--            ->where('is_completed', false)-->
<!--            ->orderBy('match_date')-->
<!--            ->get();-->
            
            
<!--$completedFixtures = \App\Models\Fixture::with(['homeTeam', 'awayTeam'])-->
<!--            ->where('is_completed', true)-->
<!--            ->orderByDesc('match_date')-->
<!--            ->paginate(10);-->

<!--@endphp-->
 <ul class="nav nav-tabs" id="fixturesTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab">
                Upcoming ({{ $currentSunday }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab">
                Completed
            </a>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="fixturesTabContent">
        <!-- Upcoming Fixtures Tab -->
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
            @if($upcomingFixtures->count() > 0)
                <div class="table-responsive-md mt-3">
                    <h3 class="text-center text-dark">Upcoming Fixtures</h3>
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            @foreach($upcomingFixtures as $fixture)
                            <tr class="table-dark">

                        <td>
                            <div class="">
                                @php
                                    $logoPath = str_replace('storage/', '', $fixture->homeTeam->logo);
                                @endphp
                                
                                    
                                    
                                    <div class="d-flex align-items-center">
       <img src="{{ $logoPath ? route('logo.show', ['filename' => basename($logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $fixture->homeTeam ? $fixture->homeTeam->name : 'Unknown Team' }}"
     style="max-width: 50px; height: auto;">
                            </div>
                        </td>
                        <td class="text-center text-light">
                            <span>{{ $fixture->homeTeam ? $fixture->homeTeam->name : 'Unknown Team' }}</span> vs  <span>{{ $fixture->awayTeam ? $fixture->awayTeam->name : 'Unknown Team' }}</span>
                            <br>

                            @if($editFixtureId === $fixture['id'])
                                <!-- Editing Date -->
                                <input type="datetime-local"
                                    wire:model="newMatchDate"
                                    class="form-control"
                                    value="{{ \Carbon\Carbon::parse($fixture->match_date)->format('Y-m-d\TH:i') }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">
                                    
                                    <br>
                                    <input type="text" name="newStadium" value="{{ old('stadium',$fixture->stadium )}} " wire:model="newStadium" class="form-control">
                            @else
                                {{ \Carbon\Carbon::parse($fixture->match_date)->format('d-m-Y') }}
                                <br>
                                {{ \Carbon\Carbon::parse($fixture->match_date)->format('h:i A') }}
                                
                                <br>
                                <span>{{ $fixture->stadium }}</span>
                            @endif

                        </td>
                        <td>
                            <div>
                                @php
                                    $logoPath = str_replace('storage/', '', $fixture->awayTeam->logo);
                                @endphp
                                <img src="{{ $logoPath ? route('logo.show', ['filename' => basename($logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $fixture->awayTeam ? $fixture->awayTeam->name : 'Unknown Team' }}"
     style="max-width: 50px; height: auto;">
                            </div>
                        </td>

                        <td>
                            @auth
                                @if(auth()->user()->role == 'admin')
                                    @if($editFixtureId === $fixture->id)
                                        <!-- Save and Cancel Buttons -->
                                        <button wire:click="updateMatchDate" class="btn btn-success">akb</button>
                                        <button wire:click="$set('editFixtureId', null)" class="btn btn-secondary">demss</button>
                                    @else
                                        <!-- Edit Button -->
                                        <button wire:click="startEditing({{ $fixture->id }}, '{{ $fixture->match_date }}')" class="btn btn-primary">nay xewta elet qeyr</button>
                                    @endif
                                @endif

                            @endauth
                        </td>


                    </tr>
                    <td class="bg-light"></td>
                    <td class="bg-light"></td>
                    <td class="bg-light"></td>
                    <td class="bg-light"></td>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h2 class="text-center mt-3">No upcoming fixtures</h2>
            @endif
        </div>

        <!-- Completed Fixtures Tab -->
        <div class="tab-pane fade" id="completed" role="tabpanel">
            @if($completedFixtures->count() > 0)
                <div class="table-responsive-md mt-3">
                    <h3 class="text-center text-dark">Completed Fixtures</h3>
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            @foreach($completedFixtures as $fixture)
                           <tr class="table-dark">

                        <td>
                            <div class="">
                                @php
                                    $logoPath = str_replace('storage/', '', $fixture->homeTeam->logo);
                                @endphp
                                
                                    
                                    
                                   <div class="d-flex align-items-center">
       <img src="{{ $logoPath ? route('logo.show', ['filename' => basename($logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $fixture->homeTeam ? $fixture->homeTeam->name : 'Unknown Team' }}"
     style="max-width: 50px; height: auto;">
                            </div>
                        </td>
                         @if($upcomingFixtures)
                        <td class="text-center text-light">
                            <span>{{ $fixture->homeTeam ? $fixture->homeTeam->name : 'Unknown Team' }} </span> vs <span>{{ $fixture->awayTeam ? $fixture->awayTeam->name : 'Unknown Team' }}</span>
                            <br>
                            <span class="text-right">{{ $fixture->home_score }} </span> - <span class="text-left">{{ $fixture->away_score }}</span>
                            <br>
                            {{ \Carbon\Carbon::parse($fixture->match_date)->format('d-m-Y') }}

                        </td>
                        @endif
                        <td>
                            <div>
                                @php
                                    $logoPath = str_replace('storage/', '', $fixture->awayTeam->logo);
                                @endphp
                                <img src="{{ $logoPath ? route('logo.show', ['filename' => basename($logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $fixture->awayTeam ? $fixture->awayTeam->name : 'Unknown Team' }}"
     style="max-width: 50px; height: auto;">
                            </div>
                        </td>

                    </tr>
                    <td class="bg-light"></td>
                    <td class="bg-light"></td>
                    <td class="bg-light"></td>
                    <td class="bg-light"></td>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $completedFixtures->links() }}
                    </div>
                </div>
            @else
                <h2 class="text-center mt-3">No completed fixtures</h2>
            @endif
        </div>
    </div>
</div>
</div>

</div>















