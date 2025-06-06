<div>
    <h2 class="text-center mb-4">መዝግብ ሽቶታት</h2>
    <table class="table mt-3 table table-bordered table-dark table-striped .table-responsive{-sm|-md|-lg|-xl|-xxl} .table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>ኣኣንጋዲት ጋንታ</th>
                <th>ተኣጋዲ ጋንታ</th>
                <th>ኣኣንጋዲት ሸቶ</th>
                <th>ተኣንጋዲት ሸቶ</th>
                @auth
                @if(!auth()->user()->is_admin)
                <th>መሳርሒ</th>
                @endif
                @endauth

            </tr>
        </thead>
        <tbody>
            @foreach($matches as $index => $match)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $match->homeTeam->name }}</td>
                <td>{{ $match->awayTeam->name }}</td>
                <td>
                    <input
                        type="number"
                        wire:model.lazy="matches.{{ $index }}.home_score"
                        class="form-control"
                        min="0"
                    >
                </td>
                <td>
                    <input
                        type="number"
                        wire:model.lazy="matches.{{ $index }}.away_score"
                        class="form-control"
                        min="0"
                    >
                </td>
                <td>
                    @auth
                    @if(!auth()->user()->is_admin)
                    <button
                        wire:click="updateScore({{ $match->id }}, {{ $matches[$index]['home_score'] }}, {{ $matches[$index]['away_score'] }})"
                        class="btn btn-success"
                    >
                        ዓቅብ
                    </button>
                    @endif
                    @endauth

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
