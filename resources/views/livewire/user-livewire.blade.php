@extends('components.layouts.app')

@section('content')

@php
    $clubs = App\Models\Club::all();
    @endphp
    <div class="table table-striped table-bordered table-hover table-responsive-sm">
    <h3 class="text-center mb-3">nay 12 gantatat texaweti mezgbe <br>     ናይ 12 ጋንታታት ተጻወቲ መዝገብ      </h3>

    <table class="table mobile-small-text table-striped table-bordered table-hover table-md">
        <thead class="table-dark">
            <tr>
                @foreach($clubs as $club)
                    <th>{{ $club->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr class="table-dark">
                @foreach($clubs as $club)
                    <td>
                        @foreach($club->players()->orderBy('number')->get() as $player)
                          {{ $loop->index + 1 }}.
                            <div class="d-flex align-items-center">
                                <img src="{{ $player->photo ? route('photo.show', ['filename' => basename($player->photo)]) : asset('storage/photos/dummy.png') }}"
                                     class="img-fluid me-2"
                                     alt="{{ $player->name }}"
                                     style="max-width: 50px; height: auto;">
                                <span>{{ $player->number }} <br> {{ $player->name }}</span>
                            </div>
                        @endforeach
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
