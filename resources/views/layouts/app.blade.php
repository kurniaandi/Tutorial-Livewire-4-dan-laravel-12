<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen text-gray-800 antialiased">

    <!-- Background Gradient -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-indigo-500/20 via-sky-400/20 to-purple-500/20"></div>

    <!-- Header -->
    <header class="sticky top-0 z-30">
        <div class="backdrop-blur-md bg-white/60 border-b border-white/30 shadow-sm">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

                <!-- Brand -->
                <a href="/" wire:navigate
                    class="text-lg font-semibold tracking-tight text-gray-900 hover:text-indigo-600 transition">
                    {{ config('app.name') }}
                </a>

                <!-- Navigation -->
                <nav class="flex items-center gap-6 text-sm font-medium">
                    <a href="/" wire:navigate
                        class="text-gray-600 hover:text-indigo-600 transition
                  {{ request()->is('/') ? 'text-indigo-600' : '' }}">
                        Home
                    </a>

                    <a href="/posts" wire:navigate
                        class="text-gray-600 hover:text-indigo-600 transition
                  {{ request()->is('posts*') ? 'text-indigo-600' : '' }}">
                        Posts
                    </a>
                </nav>
            </div>

        </div>
    </header>

    <!-- Content -->
    <main class="max-w-6xl mx-auto px-6 py-10">
        <div
            class="relative rounded-2xl bg-white/70 backdrop-blur-xl
                   border border-white/30 shadow-xl p-6 md:p-8">

            <!-- Optional decorative blur -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-400/30 rounded-full blur-3xl"></div>

            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center text-xs text-gray-500 py-6">
        © {{ date('Y') }} {{ config('app.name') }} •
        Dibuat oleh
        <a href="https://lagikoding.com"
            target="_blank"
            class="font-medium text-indigo-600 hover:text-indigo-700">
            lagikoding.com
        </a>
        • Laravel12 & Livewire4
    </footer>

    @livewireScripts
</body>

</html>