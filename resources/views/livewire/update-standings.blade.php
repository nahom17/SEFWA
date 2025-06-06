<div>
    <h2 class="mb-4">nay xewta wxiet memlei</h2>

    <!-- Debugging Helper -->
    <div wire:ignore class="text-muted small">
        Selected Fixture ID: {{ $selectedFixtureId ?? 'None' }}
    </div>

    <!-- Flash messages -->
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (Auth::user()->role === 'admin')
        <!-- Mode Toggle Buttons -->
        <div class="btn-group mb-4">
            <button type="button" 
                    wire:click="disableEditMode" 
                    class="btn {{ !$isEditMode ? 'btn-primary' : 'btn-outline-primary' }}">
                Add New Results
            </button>
            <button type="button" 
                    wire:click="enableEditMode" 
                    class="btn {{ $isEditMode ? 'btn-primary' : 'btn-outline-primary' }}">
                Edit Existing Results
            </button>
        </div>

        <div class="mt-4">
            <h4>{{ $isEditMode ? 'Edit Match Results' : 'xewat wxiet aere' }}</h4>

            <!-- Fixture Selection -->
            <div class="form-group">
                <label for="fixture">{{ $isEditMode ? 'Select Match to Edit:' : 'gtm xweta mrex:' }}</label>
                <select wire:model.live="selectedFixtureId"
                        id="fixture"
                        class="form-control"
                        wire:loading.attr="disabled">
                    <option value="">-- {{ $isEditMode ? 'Select Match' : 'xewta gtm mrex' }} --</option>
                    
                    @if($isEditMode)
                        @foreach ($completedFixtures as $fixture)
                            <option value="{{ $fixture->id }}">
                                {{ $fixture->homeTeam->name }} {{ $fixture->home_score }} - {{ $fixture->away_score }} {{ $fixture->awayTeam->name }} ({{ $fixture->match_date }})
                            </option>
                        @endforeach
                    @else
                        @foreach ($fixtures as $fixture)
                            <option value="{{ $fixture->id }}"
                                    {{ $fixture->is_completed ? 'disabled' : '' }}>
                                {{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }} ({{ $fixture->match_date }})
                            </option>
                        @endforeach
                    @endif
                </select>
                <div wire:loading wire:target="selectedFixtureId">
                    Loading players...
                </div>
            </div>

            <!-- Show form only when valid fixture is selected -->
            @if(!empty($selectedFixtureId))
                <div wire:key="fixture-form-{{ $selectedFixtureId }}">
                    <!-- Score Inputs -->
                    <div class="form-group">
                        <label for="home_score">anagti ganta shto:</label>
                        <input type="number"
                               wire:model.lazy="homeTeamScore"
                               id="home_score"
                               class="form-control"
                               min="0"
                               required>
                        @error('homeTeamScore') <span class="text-danger">{{ $message }}</span> @enderror
                        @error('homeScores') <span class="text-danger d-block">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="away_score">teagadit ganta sheto:</label>
                        <input type="number"
                               wire:model.lazy="awayTeamScore"
                               id="away_score"
                               class="form-control"
                               min="0"
                               required>
                        @error('awayTeamScore') <span class="text-danger">{{ $message }}</span> @enderror
                        @error('awayScores') <span class="text-danger d-block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Scorers Section -->
                    @if(count($availableHomePlayers) > 0 || count($availableAwayPlayers) > 0)
                        <div class="scorers-section mt-4">
                            <!-- Home Scorers -->
                            <div class="home-scorers mb-4">
                                <h4>{{ $fixtures->find($selectedFixtureId)->homeTeam->name ?? $completedFixtures->find($selectedFixtureId)->homeTeam->name }} Scorers</h4>
                                @foreach($homeScores as $index => $scorer)
                                    <div class="scorer-input mb-2">
                                        <select wire:model="homeScores.{{ $index }}.player_id"
                                                class="form-control d-inline-block w-50">
                                            <option value="">Select Player</option>
                                            @foreach($availableHomePlayers as $player)
                                                <option value="{{ $player->id }}">{{$player->number}} {{ $player->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number"
                                               wire:model="homeScores.{{ $index }}.goals"
                                               class="form-control d-inline-block w-25 mx-2"
                                               min="1">
                                        <button type="button"
                                                wire:click="removeHomeScorer({{ $index }})"
                                                class="btn btn-danger btn-sm">
                                            ×
                                        </button>
                                        @error("homeScores.{$index}.player_id") <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                @endforeach
                                <button type="button"
                                        wire:click="addHomeScorer"
                                        class="btn btn-secondary btn-sm">
                                    Add Home Scorer +
                                </button>
                            </div>

                            <!-- Away Scorers -->
                            <div class="away-scorers">
                                <h4>{{ $fixtures->find($selectedFixtureId)->awayTeam->name ?? $completedFixtures->find($selectedFixtureId)->awayTeam->name }} Scorers</h4>
                                @foreach($awayScores as $index => $scorer)
                                    <div class="scorer-input mb-2">
                                        <select wire:model="awayScores.{{ $index }}.player_id"
                                                class="form-control d-inline-block w-50">
                                            <option value="">Select Player</option>
                                            @foreach($availableAwayPlayers as $player)
                                                <option value="{{ $player->id }}">{{$player->number}} {{ $player->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number"
                                            wire:model="awayScores.{{ $index }}.goals"
                                            class="form-control d-inline-block w-25 mx-2"
                                            min="1">
                                        <button type="button"
                                                wire:click="removeAwayScorer({{ $index }})"
                                                class="btn btn-danger btn-sm">
                                            ×
                                        </button>
                                        @error("awayScores.{$index}.player_id") <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                @endforeach
                                <button type="button"
                                        wire:click="addAwayScorer"
                                        class="btn btn-secondary btn-sm">
                                    Add Away Scorer +
                                </button>
                            </div>
                        </div>

                        <!-- Home Team Assists -->
                        <div class="home-assists mb-4">
                            <h4>{{ $fixtures->find($selectedFixtureId)->homeTeam->name ?? $completedFixtures->find($selectedFixtureId)->homeTeam->name }} Assists</h4>
                            @foreach($homeAssists as $index => $assist)
                                <div class="assist-input mb-2">
                                    <select wire:model="homeAssists.{{ $index }}.player_id"
                                            class="form-control d-inline-block w-50">
                                        <option value="">Select Player</option>
                                        @foreach($availableHomePlayers as $player)
                                            <option value="{{ $player->id }}">{{$player->number}} {{ $player->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number"
                                           wire:model="homeAssists.{{ $index }}.assists"
                                           class="form-control d-inline-block w-25 mx-2"
                                           min="0">
                                    <button type="button"
                                            wire:click="removeHomeAssist({{ $index }})"
                                            class="btn btn-danger btn-sm">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                            <button type="button"
                                    wire:click="addHomeAssist"
                                    class="btn btn-secondary btn-sm">
                                Add Home Assist +
                            </button>
                        </div>

                        <!-- Away Team Assists -->
                        <div class="away-assists">
                            <h4>{{ $fixtures->find($selectedFixtureId)->awayTeam->name ?? $completedFixtures->find($selectedFixtureId)->awayTeam->name }} Assists</h4>
                            @foreach($awayAssists as $index => $assist)
                                <div class="assist-input mb-2">
                                    <select wire:model="awayAssists.{{ $index }}.player_id"
                                            class="form-control d-inline-block w-50">
                                        <option value="">Select Player</option>
                                        @foreach($availableAwayPlayers as $player)
                                            <option value="{{ $player->id }}">{{$player->number}} {{ $player->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number"
                                           wire:model="awayAssists.{{ $index }}.assists"
                                           class="form-control d-inline-block w-25 mx-2"
                                           min="0">
                                    <button type="button"
                                            wire:click="removeAwayAssist({{ $index }})"
                                            class="btn btn-danger btn-sm">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                            <button type="button"
                                    wire:click="addAwayAssist"
                                    class="btn btn-secondary btn-sm">
                                Add Away Assist +
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning mt-3">
                            No players found for selected teams
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button wire:click="submitResult"
                            wire:loading.attr="disabled"
                            class="btn btn-primary mt-3">
                        <span wire:loading.remove>
                            {{ $isEditMode ? 'Update Result' : 'wxiet xeano' }}
                        </span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>