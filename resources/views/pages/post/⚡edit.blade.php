<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component
{
    use WithFileUploads;

    public Post $post;

    #[Validate('nullable|image|max:2048')]
    public $image;

    #[Validate('required|string')]
    public $title;

    #[Validate('required|string')]
    public $content;

    public function mount(Post $post)
    {
        $this->post    = $post;
        $this->title   = $post->title;
        $this->content = $post->content;
    }

    public function update()
    {
        $this->validate();

        if ($this->image) {
            $this->image->storeAs(
                'posts',
                $this->image->hashName(),
                'public'
            );

            $this->post->image = $this->image->hashName();
        }

        $this->post->update([
            'title'   => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Post berhasil diperbarui.');

        return $this->redirect('/posts', navigate: true);
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Edit Post');
    }
};
?>

<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
            Edit Post
        </h1>
        <p class="text-sm text-gray-600">
            Perbarui konten post dengan tampilan modern.
        </p>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="bg-green-500/10 border border-green-500/20
                    text-green-700 px-4 py-3 rounded-xl backdrop-blur">
            {{ session('message') }}
        </div>
    @endif

    {{-- Form Card --}}
    <div class="rounded-2xl bg-white/70 backdrop-blur-xl
                border border-white/30 shadow-xl p-6 md:p-8 space-y-6">

        <form wire:submit.prevent="update" class="space-y-6" enctype="multipart/form-data">

            {{-- Current Image --}}
            @if ($post->image)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Image
                    </label>

                    <img
                        src="{{ asset('storage/posts/' . $post->image) }}"
                        class="w-48 h-32 object-cover rounded-xl shadow"
                    >
                </div>
            @endif

            {{-- Upload New Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Replace Image (optional)
                </label>

                <input
                    type="file"
                    wire:model="image"
                    class="block w-full text-sm text-gray-700
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-xl file:border-0
                           file:bg-indigo-500/10 file:text-indigo-700
                           hover:file:bg-indigo-500/20"
                >

                @error('image')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror

                {{-- Preview New Image --}}
                @if ($image)
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        class="mt-4 w-48 h-32 object-cover rounded-xl shadow"
                    >
                @endif
            </div>

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Title
                </label>

                <input
                    type="text"
                    wire:model.defer="title"
                    class="w-full rounded-xl border border-white/40 bg-white/60
                           px-4 py-2 text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                >

                @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Content
                </label>

                <textarea
                    wire:model.defer="content"
                    rows="6"
                    class="w-full rounded-xl border border-white/40 bg-white/60
                           px-4 py-2 text-gray-900
                           focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                ></textarea>

                @error('content')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button
                    type="submit"
                    class="inline-flex items-center px-5 py-2.5 rounded-xl
                           bg-indigo-600 text-white text-sm font-medium
                           hover:bg-indigo-700 transition shadow">
                    Update Post
                </button>

                <a
                    href="/posts"
                    wire:navigate
                    class="inline-flex items-center px-5 py-2.5 rounded-xl
                           bg-gray-500/80 text-white text-sm font-medium
                           hover:bg-gray-600 transition shadow">
                    Back
                </a>
            </div>

        </form>
    </div>
</div>
