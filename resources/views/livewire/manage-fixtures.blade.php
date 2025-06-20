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

    @php
                    //$fixtureIds = [5, 55];
//$fixtures = \App\Models\Fixture::whereIn('id', $fixtureIds) ->where('is_completed', false) ->orderBy('match_date') ->get();

                     // $fixtures = \App\Models\Fixture::whereDate('match_date', '2025-06-01')->where('is_completed', false)->orderBy('match_date')->get();
                   $fixtures = \App\Models\Fixture::where('is_completed', false)->orderBy('match_date')->get();
                    $results = \App\Models\Fixture::where('is_completed', true)->orderBy('match_date' , 'desc')->get();
                    $upcoming = \App\Models\Fixture::where('is_completed', false)->get();
                    //$fixtures = \App\Models\Fixture::all()->sortBy('match_date');

            // ->orderBy('match_date', 'asc')
            // ->paginate(198);
                @endphp



     @auth
        @if(auth()->user()->role == 'admin'  && $fixtures->count() == 0)
            <button wire:click="generateFixtures" class="btn btn-primary mb-3">gtmat srae</button>
        @endif
    @endauth

    @if($fixtures->count() > 0)

<h2 class="text-center text-dark"> 🗓️Upcoming Fixtures </br>🗓️nay zmexie  mesre gtmat <br> 🗓️ናይ ዝመጽእ መስርዕ ግጥማት  </br>01-06-2025</h2>
<div class="table-responsive-md">

    <table class="table mobile-small-text table-striped table-bordered table-hover table-md">

    <thead>

    </thead>
    <tbody>
        @foreach($fixtures as $fixture)

                    <tr class="table-dark">

                        <td>
                            <div class="">
                                @php
                                    $logoPath = str_replace('storage/', '', $fixture->homeTeam->logo);
                                @endphp
                                <!--<img style="width: 50px; height: 50px; margin-right: 10px;"-->
                                <!--    src="{{ asset('storage/' . $logoPath) }}"-->
                                <!--    alt="">-->


                                    <div class="d-flex align-items-center">
       <img src="{{ $logoPath ? route('logo.show', ['filename' => basename($logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $fixture->homeTeam ? $fixture->homeTeam->name : 'Unknown Team' }}" title="Club name"
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
                                    <br>
                                    <input type="text" name="newInformation" value="{{ old('information',$fixture->information )}} " wire:model="newInformation" class="form-control">
                            @else
                                {{ \Carbon\Carbon::parse($fixture->match_date)->format('d-m-Y') }}
                                <br>
                                {{ \Carbon\Carbon::parse($fixture->match_date)->format('h:i A') }}

                                <br>
                                <span>{{ $fixture->stadium }}</span>
                                <br>
                                <span class="text-warning">{{ $fixture->information }}</span>
                            @endif

                        </td>
                        <td>
                            <div>
                                @php
                                    $logoPath = str_replace('storage/', '', $fixture->awayTeam->logo);
                                @endphp
                                <img src="{{ $logoPath ? route('logo.show', ['filename' => basename($logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $fixture->awayTeam ? $fixture->awayTeam->name : 'Unknown Team' }}" title="Club name"
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

        <div class="d-flex justify-content-center">
        <div class="pagination pagination-sm">
            {{-- {{ $fixtures->links() }} --}}
        </div>
    </div>
    </div>
    @else
        <h2 class="text-center">Senbet  gtmat yelon erefti eyu <br> ሰንበት ግጥማት የለን ዕረፍቲ እዩ</h2>
    @endif

<hr><div class="container mt-4">  <!-- Removed duplicate mt-3 -->
    <div class="remit-banner mt-5">
        <div class="remit-logo">Remitly ናብ ኩሉ ሃገራት መሓወሊ</div>

        <div class="remit-offer">
            ናብ ዝደለኻዮ ቦታ ገንዘብ ኪሰድድ ትኸእል
            <span class="remit-highlight">10 ኢሮ ሞቕሺሽ(bonus)</span>
            €100 ምስ እትሰድድ
        </div>

        <div class="remit-benefits">
            <div class="remit-benefit-item">
                <span class="remit-check">✅</span>
                ውሑስ ኣብ ግዜዩ ዝበጽሕ ብፍላይ ናብ ኤርትርያ፡ ኢትዮጵያ ካልኦት ሃገራትን
            </div>

            <div class="remit-benefit-item">
                <span class="remit-check">✅</span>
                ዝላዓለ ናይ ሸርፉ ብዝሒ ኣለዎ ፡ ምሰደዲ ከኣ 5 ኢሮ ብዝሒ እትሰዶ ገንዘብ ብዘይገድስ ።
            </div>

            <div class="remit-benefit-item">
                <span class="remit-check">✅</span>  <!-- Added for consistency -->
                ናብ ኤርትራ €100 ብ ኣስታት 1550 ክሳብ 1650 ናቕፋ <br> አዚ ሰሙን 100 euro b 1679 ኣላ
            </div>

            <div class="remit-benefit-item">
                <span class="remit-check">✅</span>
                አቲ ገንዘብ ምስ ሰደካዪ ነቲ ተቀባሊ መልእኽቲ ይበጽሖ አዩ።
            </div>
        </div>

        <div class="remit-cta">
            <a href="https://www.remitly.com/nl/nl/share-NLD-ERI?ref_code=bd16e9dd&utm_campaign=nld-any-10-10-min-100-0724&utm_medium=copy&utm_source=referralprogram&utm_term=rewards_dashboard_no_rewards">
                ብዝሒ  ትሰዶ ብዘይ የገድስ በዛ <br>link መሰዲ ከይከፈልካ ኪሰድድ ይከኣል  <br> 5 euro ከኣ ብላዕሊ ኣለካ/ኪ
            </a>
        </div>
    </div>  <!-- Closing remit-banner -->
</div>  <!-- Closing container --><hr>
    @if($results)

            <div class="table-responsive-md">


    <table class="table mobile-small-text table-striped table-bordered table-hover table-md">

        <h2 class="text-center text-dark"> ✅Completed Fixtures & Results </br>✅ nay zhalefe xewtatat wxiet <br>✅ናይ ዝሓለፈ ጸወታት ውጽኢት</h2>

    <thead>

    </thead>
    <tbody>
        @foreach($results as $fixture)

                    <tr class="table-dark">

                        <td>
                            <div class="">
                                @php
                                    $logoPath = str_replace('storage/', '', $fixture->homeTeam->logo);
                                @endphp
                                <!--<img style="width: 50px; height: 50px; margin-right: 10px;"-->
                                <!--    src="{{ asset('storage/' . $logoPath) }}"-->
                                <!--    alt="">-->


                                    <div class="d-flex align-items-center">
       <img src="{{ $logoPath ? route('logo.show', ['filename' => basename($logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $fixture->homeTeam ? $fixture->homeTeam->name : 'Unknown Team' }}"
     style="max-width: 50px; height: auto;">
                            </div>
                        </td>
                         @if($upcoming)
                        <td class="text-center text-light">
                            <span>{{ $fixture->homeTeam ? $fixture->homeTeam->name : 'Unknown Team' }} </span> vs <span>{{ $fixture->awayTeam ? $fixture->awayTeam->name : 'Unknown Team' }}</span>
                            <br>
                            <span class="text-right">{{ $fixture->home_score }} </span>  —  <span class="text-left">{{ $fixture->away_score }}</span>
                            <br>
                            {{ \Carbon\Carbon::parse($fixture->match_date)->format('d-m-Y') }}
                            <br>
                                {{ \Carbon\Carbon::parse($fixture->match_date)->format('h:i A') }}
                             <br>
                                <span>{{ $fixture->stadium }}</span>

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

        <div class="d-flex justify-content-center">
        <div class="pagination pagination-sm">
            {{-- {{ $fixtures->links() }} --}}
        </div>
    </div>
    </div>
    @else
        <h2 class="text-center">Fc Barentu is the winner of EriHolland leauge 2025 </h2>
    @endif

</div>