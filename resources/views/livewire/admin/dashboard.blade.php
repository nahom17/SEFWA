@extends('components.layouts.app')
@section('content')
    <div id="app">
        <div class="container mt-5 mb-5 text-center end">
        <a href="https://nahomapp.com/">
            <button class="btn btn-info">userdashbord</button>
        </a>
        
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <h1 class="text-center">Nay eritrea ketematat xewta ab holand 2025</h1>
        <h2 class="text-center">enkae b dehan mexaeka/ki, {{ auth()->user()->name }}</h2>
        <ul class="nav nav-tabs mt-4" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#clubs" role="tab">gantatat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#players" role="tab">texaweti</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#fixtures" role="tab"> mesr gtmat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#EditStandings" role="tab">wxet xewetatat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#standings" role="tab">dereja gantatat</a>
            </li>

        </ul>

        <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="clubs" role="tabpanel">
                <livewire:clubs />
            </div>
            <div class="tab-pane fade" id="players" role="tabpanel">
                <livewire:ManagePlayer />
            </div>
            <div class="tab-pane fade" id="fixtures" role="tabpanel">
                <livewire:ManageFixtures />
            </div>
            <div class="tab-pane fade" id="EditStandings" role="tabpanel">
                    <livewire:UpdateStandings />
                    </div>
                    <div class="tab-pane fade" id="standings" role="tabpanel">
                <livewire:ManageStandings />
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
