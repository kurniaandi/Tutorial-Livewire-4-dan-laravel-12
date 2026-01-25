<?php

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component
{
    use WithFileUploads;

    #[Validate('required|image|max:2048')]
    public $image;

    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('required')]
    public $content = '';

    public function store()
    {
        $this->validate();

        $imagePath = $this->image->store('posts', 'public');

        Post::create([
            'image'   => basename($imagePath),
            'title'   => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('message', 'Post berhasil disimpan.');

        return $this->redirect('/posts', navigate: true);
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app')
            ->title('Create Post');
    }
};
?>

<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-gray-900">
            Create Post
        </h1>
        <p class="text-sm text-gray-600">
            Tambahkan post baru dengan tampilan modern.
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

        <form wire:submit.prevent="store" class="space-y-6">

            {{-- Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Featured Image
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

                {{-- Preview --}}
                @if ($image)
                    <div class="mt-4">
                        <img
                            src="{{ $image->temporaryUrl() }}"
                            class="w-48 h-32 object-cover rounded-xl shadow"
                        >
                    </div>
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
                    placeholder="Judul post..."
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
                    placeholder="Tulis konten post..."
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
                    Save Post
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
