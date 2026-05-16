<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SafeNeighbor - A community platform where residents can report local incidents, coordinate with neighbors, and receive safety alerts.">
    <meta name="theme-color" content="#1E2A4A">
    <link rel="canonical" href="{{ url()->current() }}">

    <title>{{ config('app.name', 'SafeNeighbor') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:400,600,700|inter:400,500,600|jetbrains-mono:400" rel="stylesheet" />
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <style>
        :root[data-theme="dark"] {
            --color-background-primary: #121212;
            --color-background-secondary: #1F2937;
            --color-text-primary: #F9FAFB;
            --color-text-secondary: #D1D5DB;
            --color-border-primary: #374151;
            --color-border-secondary: #4B5563;
            --color-border-tertiary: #1F2937;
            --bg-card: #111827;
            
            /* Badge Colors for Dark Mode */
            --color-background-danger: rgba(201, 64, 64, 0.2);
            --color-text-danger: #FCA5A5;
            --color-background-warning: rgba(232, 160, 48, 0.2);
            --color-text-warning: #FCD34D;
            --color-background-success: rgba(99, 153, 34, 0.2);
            --color-text-success: #A7F3D0;
            --color-background-info: rgba(26, 115, 232, 0.2);
            --color-text-info: #93C5FD;
            
            /* Overrides for app.css */
            --color-heading: #F9FAFB;
            --color-sand: #374151; /* Dark border for cards, etc. */
            
            /* Precise Foreground Text Overrides */
            --text-navy: #F9FAFB;
            --text-charcoal: #F9FAFB;
            --text-cream: #F9FAFB;
            
            /* Precise Background Overrides */
            --bg-cream: #1F2937;
            --bg-navy: #111827;
            --bg-input: #1F2937;
        }

        body {
            background-color: var(--color-background-primary, #FDFDFD);
            color: var(--color-text-primary, #1E2A4A);
        }

        /* BADGES */
        :root {
            --badge-gray-bg: #E0E0E0; --badge-gray-text: #555; --badge-gray-border: #CCCCCC;
            --badge-red-bg: #FDE8E8; --badge-red-text: #C94040; --badge-red-border: #F8B4B4;
            --badge-amber-bg: #FEF9F1; --badge-amber-text: #E8A030; --badge-amber-border: #FCE3B4;
            --badge-blue-bg: #E8F0FE; --badge-blue-text: #1A73E8; --badge-blue-border: #B4D0F8;
            --badge-green-bg: #EDF3EC; --badge-green-text: #5C6B3A; --badge-green-border: #C4D3B0;
        }

        :root[data-theme="dark"] {
            --badge-gray-bg: #374151; --badge-gray-text: #D1D5DB; --badge-gray-border: #4B5563;
            --badge-red-bg: rgba(201, 64, 64, 0.2); --badge-red-text: #FCA5A5; --badge-red-border: rgba(201, 64, 64, 0.4);
            --badge-amber-bg: rgba(232, 160, 48, 0.2); --badge-amber-text: #FCD34D; --badge-amber-border: rgba(232, 160, 48, 0.4);
            --badge-blue-bg: rgba(26, 115, 232, 0.2); --badge-blue-text: #93C5FD; --badge-blue-border: rgba(26, 115, 232, 0.4);
            --badge-green-bg: rgba(99, 153, 34, 0.2); --badge-green-text: #A7F3D0; --badge-green-border: rgba(99, 153, 34, 0.4);
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-gray { background: var(--badge-gray-bg); color: var(--badge-gray-text); border: 1px solid var(--badge-gray-border); }
        .badge-red { background: var(--badge-red-bg); color: var(--badge-red-text); border: 1px solid var(--badge-red-border); }
        .badge-amber { background: var(--badge-amber-bg); color: var(--badge-amber-text); border: 1px solid var(--badge-amber-border); }
        .badge-blue { background: var(--badge-blue-bg); color: var(--badge-blue-text); border: 1px solid var(--badge-blue-border); }
        .badge-green { background: var(--badge-green-bg); color: var(--badge-green-text); border: 1px solid var(--badge-green-border); }
    </style>

    <!-- Theme Init Script -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Relative Time JS Helper -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-timestamp]').forEach(function(el) {
                const date = new Date(el.getAttribute('data-timestamp'));
                const now = new Date();
                const seconds = Math.floor((now - date) / 1000);
                
                let interval = seconds / 31536000;
                if (interval > 1) { el.textContent = Math.floor(interval) + " years ago"; return; }
                interval = seconds / 2592000;
                if (interval > 1) { el.textContent = Math.floor(interval) + " months ago"; return; }
                interval = seconds / 86400;
                if (interval > 1) { el.textContent = Math.floor(interval) + " days ago"; return; }
                interval = seconds / 3600;
                if (interval > 1) { el.textContent = Math.floor(interval) + " hours ago"; return; }
                interval = seconds / 60;
                if (interval > 1) { el.textContent = Math.floor(interval) + " minutes ago"; return; }
                el.textContent = "Just now";
            });
        });
    </script>
</head>
<body>
    @include('components.nav')
    
    @if(session('success') || session('error') || session('warning'))
        <x-alert-banner :type="session('error') ? 'error' : (session('warning') ? 'warning' : 'success')" :message="session('success') ?? session('error') ?? session('warning')" />
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-navy text-cream p-6 mt-4" style="border-top: 4px solid var(--color-sand);">
        <div class="container flex justify-between items-center">
            <div>
                <p class="font-heading" style="font-size: 1.5rem;">SafeNeighbor</p>
                <p>Built for communities, by communities.</p>
                <div class="mt-4 flex gap-4 text-sm">
                    <a href="{{ route('dashboard') }}" class="text-sand" style="text-decoration:none;">Dashboard</a>
                    <a href="{{ route('incidents.create') }}" class="text-sand" style="text-decoration:none;">Report Incident</a>
                    <a href="{{ route('announcements.index') }}" class="text-sand" style="text-decoration:none;">Announcements</a>
                </div>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 3L2 12h3v8h14v-8h3L12 3zm0 2.83l6 5.4V18H6v-6.77l6-5.4z"/>
                </svg>
            </div>
        </div>
    </footer>
    <script>
        // Count up animation
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.count-up');
            const speed = 200;

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const inc = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });

            // Theme toggle logic
            const themeToggle = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            
            if (themeToggle) {
                const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
                themeIcon.className = isDark ? 'ti ti-sun' : 'ti ti-moon';

                themeToggle.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    if (newTheme === 'dark') {
                        document.documentElement.setAttribute('data-theme', 'dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.removeAttribute('data-theme');
                        localStorage.setItem('theme', 'light');
                    }
                    
                    themeIcon.className = newTheme === 'dark' ? 'ti ti-sun' : 'ti ti-moon';
                });
            }
        });
    </script>
</body>
</html>
