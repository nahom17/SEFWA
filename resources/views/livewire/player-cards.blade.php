 <div class="table table table-striped table-bordered table-hover table-responsive-sm">
     <h3 class="text-center mb-3">⚽ Top 10Scorers</br>⚽ 10 bluxat amezgebti sheto <br> ⚽10 ብሉጻት ኣመዝገብቲ ሸቶ </h3>
        <table class="table mobile-small-text table-striped table-bordered table-hover table-md">
    <thead class="table-dark">
        
    </thead>
    <tbody>
       @if($topScorers)
        @foreach($topScorers as $index => $player)
        <tr class="table-dark">
            <td>
                @if($player->photo !== null)
                <div class="d-flex align-items-center">
                           <img src="{{  $player->photo ? route('photo.show', ['filename' => basename( $player->photo)]) : asset('storage/photos/dummy.png') }}"
     class="img-fluid rounded-circle m-2"
     alt="{{ $player->name }}" title="Tops 10 Scorers"
     style="max-width: 100px; height:auto;">
                           <span>{{ $player->number }}.{{ $player->name }} <br>  ጋንታ  {{ $player->club->name }}</span>
                        </div>
                        
                        @else
                        <div class="d-flex align-items-left">
                           <img src="https://nahomapp.com/storage/photos/dummy.png"
     class="img-fluid rounded-circle"
     alt="{{ $player->name }}" title="Tops 10 Scorers"
     style="max-width: 100px; height:auto;">
                             <span>{{ $player->number }}.{{ $player->name }} <br>  ጋንታ  {{ $player->club->name }}</span>
                        </div>
                        @endif</td>
           
            <td class="text-warning"><strong>{{$player->total_goals }} ⚽ </strong> </td>
        </tr>
        @endforeach
        @else
        
        <h3 class="text-center"> kab senebt sheto zemezgebu abzi ymzgebu <br>  ካብ  ሰንበት ሸቶ ዘመዝገቡ ኣብዚ ይምዝገቡ             </h3>
      @endif
    </tbody>
</table>




<h3 class="text-center mb-3"> 🎯Top 10 Assists </br>🎯  10 bluxat tehagagezti  <br>🎯 10 ብሉጻት ተሓጋገዝቲ</h3>
        <table class="table mobile-small-text table-striped table-bordered table-hover table-md">
    <thead class="table-dark">
        
    </thead>
    <tbody>
         @if( $topAssistants)
        @foreach( $topAssistants as $index => $player )
        
        <tr class="table-dark">
            <td>
                @if($player->photo !== null)
                <div class="d-flex align-items-center">
                           <img src="{{  $player->photo ? route('photo.show', ['filename' => basename( $player->photo)]) : asset('storage/photos/dummy.png') }}"
     class="img-fluid rounded-circle m-2"
     alt="{{ $player->name }}" title="Tops 10 Assists"
     style="max-width: 100px; height:auto;">
                             <span>{{ $player->number }}.{{ $player->name }} <br>  ጋንታ  {{ $player->club->name }}</span>
                        </div>
                        
                        @else
                        <div class="d-flex align-items-center">
                          <img src="https://nahomapp.com/storage/photos/dummy.png"
     class="img-fluid rounded-circle m-2"
     alt="{{ $player->name }}"  title="Tops 10 Assists"
     style="max-width: 100px; height:auto;">
                             <span>{{ $player->number }}.{{ $player->name }} <br>  ጋንታ  {{ $player->club->name }}</span>
                        </div>
                       
                        @endif</td>
           
            <td><strong>{{ $player->total_assists }} Assists</strong>  </td>
        </tr>
        @endforeach
        
        @else
        
        <h3 class="text-center">   kab senebt ztehagagezu abzi ymzgebu  <br> ካብ ሰንበት   ተሓጋገዙ ኣብዚ ይምዝገቡ      </h3>
        @endif
    </tbody>
</table>
</div>











