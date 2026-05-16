<x-app-layout>
    <div class="container py-20 text-center">
        <div class="text-9xl font-heading text-amber mb-4">404</div>
        <h1 class="text-3xl font-bold text-navy mb-4">Page Not Found</h1>
        <p class="text-lg opacity-80 max-w-lg mx-auto mb-8">We searched the whole neighborhood, but we couldn't find the page you're looking for.</p>
        
        <div class="flex justify-center gap-4">
            <a href="{{ route('dashboard') }}" class="btn-primary">Return to Dashboard</a>
            <a href="{{ route('home') }}" class="btn-secondary text-charcoal">Go Home</a>
        </div>
        
        <div class="wavy-divider" style="margin-top: 4rem; opacity: 0.5;"></div>
    </div>
</x-app-layout>
