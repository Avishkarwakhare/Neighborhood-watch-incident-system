<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SafeNeighbor') }} - Admin</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=caveat:400,600,700|inter:400,500,600|jetbrains-mono:400" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <!-- Tailwind CSS (for Admin layout classes) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-cream">
    <div class="flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <aside class="bg-navy text-cream" style="width: 250px; flex-shrink: 0;">
            @include('components.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white p-4 shadow-sm flex justify-between items-center" style="border-bottom: 1px solid var(--color-sand);">
                <div class="font-heading text-navy" style="font-size: 1.5rem;">Admin Panel</div>
                <div class="flex items-center gap-4">
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-secondary" style="padding: 0.5rem 1rem; cursor: pointer; background: transparent;">
                            Exit Admin
                        </button>
                    </form>
                </div>
            </header>
            
            <main class="p-6 flex-1">
                @if(session('success'))
                    <x-alert-banner type="success" :message="session('success')" />
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
