<div>
    <style>
    
    img {
        transition: opacity 0.3s ease;
    }
    img[loading="lazy"] {
        opacity: 0;
    }
    img.loaded {
        opacity: 1;
    }
        /* Custom CSS for better mobile responsiveness */
        @media (max-width: 767.98px) {
            .table-responsive {
                border: 0;
            }
            .table-responsive table {
                width: 100%;
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
        }
    </style>

    <h2 class="text-center mb-4">gantatat</h2>

    @auth
        @if(auth()->user()->role == 'admin')
            <div class="card">
                <div class="card-header">hadas gantat aetu</div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <form wire:submit.prevent="addClub" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">sm ganta</label>
                            <input type="text" id="name" class="form-control" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="logo" class="form-label">nay ganta arma</label>
                            <input type="file" id="logo" class="form-control" wire:model="logo">
                            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">aetu</button>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    <!-- Edit Club Form -->

        <div class="card mt-4">
    <div class="card-header">ganta astekakel</div>
    <div class="card-body">
        <form wire:submit.prevent="updateClub" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="editName" class="form-label">sm ganta</label>
                <input type="text" id="editName" class="form-control" wire:model="editName">
                @error('editName') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

           <div class="mb-3">
    <label for="editLogo" class="form-label">nay ganta arma</label>
    <input type="file" id="editLogo" class="form-control" wire:model="editLogo">
    @if($editLogo)
        <img src="{{ $editLogo->temporaryUrl() }}" class="mt-2" width="50">
    @elseif($editLogoPath) {{-- Changed from $club->logo to $editLogoPath --}}
        <img src="{{ asset('storage/' . $editLogoPath) }}" 
             class="img-fluid rounded-circle mb-3 mt-3" 
             width="50"
             alt="Current Logo">
    @endif
    @error('editLogo') <span class="text-danger">{{ $message }}</span> @enderror
</div>
            <button type="submit" class="btn btn-success">astekakel</button>
            <button type="button" class="btn btn-secondary" wire:click="$set('editClubId', null)">aqarx</button>
        </form>
    </div>
</div>
    <!-- Responsive Table -->
    <div class="table-responsive">
        <table class="table mobile-small-text mt-3 table-bordered table-dark table-striped table-hover">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>sm ganta</th>
                    @auth
                        @if(auth()->user()->role == 'admin')
                            <th>mesarhi</th>
                        @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
    @foreach($clubs as $club)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
           <td>
    <div class="d-flex align-items-center">
       <img src="{{ $club->logo ? route('logo.show', ['filename' => basename($club->logo)]) : asset('fallback-logo.png') }}"
     class="img-fluid rounded-circle mb-3 mt-3"
     alt="{{ $club->name }}" title="Club name"
     style="max-width: 50px; height: auto;">
        <span>{{ $club->name }}</span>
    </div>
</td>
            <td>
                @auth
                    @if(auth()->user()->role == 'admin')
                        <button wire:click="editClub({{ $club->id }})" class="btn btn-warning btn-sm">astekakl</button>
                        <button wire:click="deleteClub({{ $club->id }})" class="btn btn-danger btn-sm">demss</button>
                    @endif
                @endauth
            </td>
        </tr>
    @endforeach
</tbody>
        </table>
    </div>
    <footer class="text-center py-4">
        <small>&copy; {{ date('Y') }}</small>
        <a href="https://nahomtesfamichael.com/" class="text-decoration-none">ናሆም App</a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @livewireScripts
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        images.forEach(img => {
            if (img.complete) {
                img.classList.add('loaded');
            } else {
                img.addEventListener('load', () => {
                    img.classList.add('loaded');
                });
            }
        });
    });
</script>
    <script>
    Livewire.on('clubUpdated', () => {
        location.reload(); // Force reload to update logos
    });
</script>
</div>
