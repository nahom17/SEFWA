<div class="card-body">
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="addPlayer">
        <div class="mb-3">
            <label for="club">ስም ጋንታኻ</label>
            <select wire:model="selectedClub" class="form-control">
                @foreach($clubs as $club)
                    <option value="{{ $club->id }}">{{ $club->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name">ምሉእ ስምካ</label>
            <input type="text" class="form-control" wire:model="name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label for="number">ቁጽሪ ማልያኻ</label>
            <input type="number" class="form-control" wire:model="number">
        </div>
        <div class="mb-3">
            <label for="position">ትጻውተሉ ቦታ</label>
            <input type="text" class="form-control" wire:model="position">
        </div>
        <div class="mb-3">
            <label for="photo">ናታክ ስእሊ</label>
            <input type="file" class="form-control" wire:model="photo">
        </div>
        <button type="submit" class="btn btn-primary">ስደዶ</button>
    </form>

    <h2 class="text-center mb-3">ኣብ ትሕቲ ዝኾኑ ተጻዋቲ</h2>
    <table class="table table-striped">
        <thead>
            
        </thead>
        <tbody>
            @foreach($players as $player)
            <tr>
               <td> @if($player->photo !== null)
                <div class="d-flex align-items-center">
                           <img src="{{  $player->photo ? route('photo.show', ['filename' => basename( $player->photo)]) : asset('storage/photos/dummy.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $player->name }}"
     style="max-width: 50px; height: auto;">
                            <span>{{ $player->number }} <br> {{ $player->name }} </span>
                        </div>
                        <td>{{ $player->club->name }}</td>
                        @else
                        <div class="d-flex align-items-center">
                           <img src="https://nahomapp.com/storage/photos/dummy.png"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $player->name }}"
     style="max-width: 50px; height: auto;">
                            <span>{{ $player->number }} <br> {{ $player->name }} </span> <br>
                        </div>
                        <td>{{ $player->club->name }}</td>
                        @endif</td>
                <td>
                    <button class="btn btn-warning" wire:click="editPlayer({{ $player->id }})" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                    <button class="btn btn-danger" wire:click="deletePlayer({{ $player->id }})">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true" wire:ignore.self
        @if($showEditModal) style="display: block; background: rgba(0,0,0,0.5);" @endif>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Player</h5>
                <button type="button" class="btn-close" wire:click="closeEditModal">
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updatePlayer">
                    <div class="mb-3 text-center">
                        <label>Current Photo</label>
                        <br>
                        <img src="{{ $photoPath ? asset('storage/' . $photoPath) : asset('storage/photos/dummy.png') }}" 
                             class="img-fluid rounded-circle" style="max-width: 100px;">
                    </div>
                    <div class="mb-3">
                        <label>Upload New Photo</label>
                        <input type="file" class="form-control" wire:model="photo">
                        @error('photo') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" wire:model="name">
                    </div>
                    <div class="mb-3">
                        <label>Number</label>
                        <input type="number" class="form-control" wire:model="number">
                    </div>
                    <div class="mb-3">
                        <label>Position</label>
                        <input type="text" class="form-control" wire:model="position">
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('closeEditModal', function () {
        var modalElement = document.getElementById('editModal');
        var modal = bootstrap.Modal.getInstance(modalElement);
        
        if (modal) {
            modal.hide();
            // Reset body styles
            document.body.style.overflow = 'auto'; // Restore scrolling
            document.body.style.paddingRight = '0px'; // Reset padding
        }
        
        // Extra cleanup for Bootstrap backdrop
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
    });
});
</script>
