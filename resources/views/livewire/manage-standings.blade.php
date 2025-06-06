<div>
    <style>
        .club-logo {
            width: 40px;
            height: 40px;
            margin-right: 8px;
            object-fit: cover;
            border-radius: 50%;
        }
        .extra-text {
            display: none;
        }
        @media (max-width: 760px) { /* For devices smaller than 576px */
            .extra-text {
                display: inline; /* Show extra text */
            }
            .short-text {
                display: none; /* Hide short text */
            }
        }
    </style>
    

    <h2 class="text-center mb-4"> 📊 Standings </br>📊 dereja gantatat <br>📊 ደረጃ ጋንታታት</h2>
 <small>
        <ul>
            <p>📖 Abbreviations & Their Meanings </br> 📖  haberieta nay ahxrote qal<br>📖   ሓበሬታ ናይ ኣሕጽሮተ ቃል       </p>
            <li>ga = Club, ganta , ጋንታ</li>
            <li>b,z= Total matches played, bzhi xewta , ብዝሒ ጸወታ</li>
            <li>a =  Wins ,awet ዓወት</li>
            <li>m = Draws, maere ማዕረ</li>
            <li>s = Losses,seret ስዕረት</li>
            <li>shf = Goal Difference,  shto fleley ሽቶ ፍልልይ</li>
            <li>n =  Points, netbi ነጥቢ</li>
        </ul>
    </small>
@if($standings)
    <div class="table table table-striped table-bordered table-hover table-responsive-sm">
        <table class="table mobile-small-text table-striped table-bordered table-hover table-md">
    <thead class="table-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">ga</th>
            <th scope="col">b,z</th>
            <th scope="col">a</th>
            <th scope="col">m</th>
            <th scope="col">s</th>
            <th scope="col">shf</th>
            <th scope="col">n</th>
        </tr>
    </thead>
    <tbody>
        @foreach($standings as $index => $standing)
        <tr class="table-dark">
            <td>{{$index + 1}}</td>
            <td><div class="d-flex align-items-center">
                            @php
                                $logoPath = str_replace('storage/', '', $standing->club->logo);
                            @endphp
                           <img src="{{  $logoPath ? route('logo.show', ['filename' => basename( $logoPath)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $standing->club->name }}"
     style="max-width: 50px; height: auto;">
                            <span>{{ $standing->club->name }}</span>
                        </div></td>
            <td>{{$standing->matches_played}}</td>
            <td>{{$standing->wins}}</td>
            <td>{{$standing->draws}}</td>
            <td>{{$standing->losses}}</td>
            <td>{{$standing->goals_difference}}</td>
            <td>{{$standing->points}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

    @else
    <p>dereja gantatat aytemedeben alo።</p>
    @endif
</div>
