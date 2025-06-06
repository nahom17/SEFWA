<div>
    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-medium text-gray-900">
            Manage Clubs
        </h1>

        <div class="mt-6">
            <form wire:submit.prevent="save" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Club Name</label>
                    <input type="text" wire:model="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700">Club Logo</label>
                    <input type="file" wire:model="logo" id="logo" class="mt-1 block w-full">
                    @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $editingClub ? 'Update Club' : 'Add Club' }}
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-medium text-gray-900">Clubs List</h2>
            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($clubs as $club)
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-5">
                            @if($club->logo)
                                <img src="{{ Storage::url($club->logo) }}" alt="{{ $club->name }}" class="w-32 h-32 object-contain mx-auto">
                            @else
                                <div class="w-32 h-32 bg-gray-100 flex items-center justify-center mx-auto">
                                    <span class="text-gray-500">No Logo</span>
                                </div>
                            @endif
                            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $club->name }}</h3>
                            <div class="mt-4 flex space-x-3">
                                <button wire:click="edit({{ $club->id }})" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $club->id }})" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
