<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public function render()
    {
        return $this->view([
            'posts' => Post::latest()->paginate(6),
        ])
            ->layout('layouts::app')
            ->title('Home');
    }
};
?>

<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">
        Latest Posts
    </h1>

    @if ($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div
                    class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                    {{-- Image --}}
                    @if ($post->image)
                        <img
                            src="{{ asset('storage/posts/' . $post->image) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-48 object-cover">
                    @else
                        <div
                            class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="p-5">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            {{ $post->title }}
                        </h2>

                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {!! strip_tags($post->content) !!}
                        </p>

                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400">
                                {{ $post->created_at->diffForHumans() }}
                            </span>

                            <a href="/posts/{{ $post->id }}"
                               wire:navigate
                               class="text-sm font-semibold text-indigo-600 hover:underline">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @else
        <div
            class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 rounded">
            Belum ada post.
        </div>
    @endif
</div>
