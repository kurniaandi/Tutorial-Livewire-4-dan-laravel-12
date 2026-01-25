<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public ?int $deleteId = null;

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        Post::findOrFail($this->deleteId)->delete();

        $this->reset('deleteId');

        session()->flash('message', 'Post berhasil dihapus.');
    }

    public function render()
    {
        return $this->view([
            'posts' => Post::latest()->paginate(2),
        ])
            ->layout('layouts::app')
            ->title('Posts List');
    }
};
?>
<div class="space-y-6">

    {{-- Flash Message --}}
    @if (session()->has('message'))
    <div class="bg-green-500/10 border border-green-500/20
                    text-green-700 px-4 py-3 rounded-xl backdrop-blur">
        {{ session('message') }}
    </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
            Posts
        </h1>

        <a href="/posts/create" wire:navigate
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                  bg-indigo-600 text-white text-sm font-medium
                  hover:bg-indigo-700 transition shadow">
            + Add Post
        </a>
    </div>

    {{-- Table Card --}}
    <div class="rounded-2xl bg-white/70 backdrop-blur-xl
                border border-white/30 shadow-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-white/60 border-b border-white/30">
                    <tr class="text-gray-700">
                        <th class="px-6 py-4 text-left">Image</th>
                        <th class="px-6 py-4 text-left">Title</th>
                        <th class="px-6 py-4 text-left">Content</th>
                        <th class="px-6 py-4 text-center w-40">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/30">
                    @forelse ($posts as $post)
                    <tr class="hover:bg-white/50 transition">
                        <td class="px-6 py-4">
                            <img
                                src="{{ asset('storage/posts/' . $post->image) }}"
                                class="w-28 h-20 object-cover rounded-lg shadow">
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $post->title }}
                        </td>

                        <td class="px-6 py-4 text-gray-600 max-w-md">
                            <div class="line-clamp-3">
                                {!! $post->content !!}
                            </div>
                        </td>

                        <td class="px-6 py-4 text-center space-x-3">
                            <a href="/posts/{{ $post->id }}/edit" wire:navigate
                                class="text-indigo-600 font-medium hover:underline">
                                Edit
                            </a>

                            <button
                                wire:click="confirmDelete({{ $post->id }})"
                                class="text-red-600 font-medium hover:underline">
                                Delete
                            </button>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-gray-500">
                            Data Post belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Delete Confirmation Modal --}}
            @if ($deleteId)
            <div
                x-data
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center">

                <!-- Backdrop -->
                <div
                    class="absolute inset-0 bg-black/40 backdrop-blur-sm"
                    wire:click="$set('deleteId', null)">
                </div>

                <!-- Modal -->
                <div
                    class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl p-6
                   animate-in fade-in zoom-in duration-200">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center
                            rounded-full bg-red-100 text-red-600">
                            🗑️
                        </div>

                        <h2 class="text-lg font-semibold text-gray-900">
                            Hapus Post?
                        </h2>
                    </div>

                    <p class="mt-3 text-sm text-gray-600">
                        Post yang dihapus tidak dapat dikembalikan.
                        Apakah kamu yakin ingin melanjutkan?
                    </p>

                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            wire:click="$set('deleteId', null)"
                            class="px-4 py-2 rounded-xl text-sm font-medium
                           bg-gray-100 hover:bg-gray-200 transition">
                            Batal
                        </button>

                        <button
                            wire:click="delete"
                            class="px-4 py-2 rounded-xl text-sm font-medium
                           bg-red-600 text-white hover:bg-red-700 transition shadow">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Pagination --}}
    <div class="pt-2">
        {{ $posts->links() }}
    </div>
</div>