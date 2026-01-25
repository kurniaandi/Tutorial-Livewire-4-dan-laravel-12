<?php

use App\Models\Post;
use Livewire\Component;

new class extends Component
{
    public Post $post;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title($this->post->title);
    }
};
?>

<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Back --}}
    <a href="/" wire:navigate
       class="inline-block mb-6 text-sm text-gray-600 hover:text-indigo-600">
        ← Back to Home
    </a>

    <article class="bg-white rounded-xl shadow overflow-hidden">

        {{-- Image --}}
        @if ($post->image)
            <img
                src="{{ asset('storage/posts/' . $post->image) }}"
                alt="{{ $post->title }}"
                class="w-full h-[420px] object-cover">
        @endif

        {{-- Content --}}
        <div class="p-6 md:p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-3">
                {{ $post->title }}
            </h1>

            <p class="text-sm text-gray-400 mb-6">
                Diposting {{ $post->created_at->diffForHumans() }}
            </p>

            <div class="prose max-w-none prose-indigo">
                {!! $post->content !!}
            </div>
        </div>

    </article>
</div>
