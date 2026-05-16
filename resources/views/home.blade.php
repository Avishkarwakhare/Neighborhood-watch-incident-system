<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-navy text-cream hero-noise relative overflow-hidden" style="padding: 6rem 0 4rem 0;">
        <div class="container relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                <!-- Left Content -->
                <div class="md:w-3/5 text-left">
                    <h1 class="mb-4" style="color: #ffffff !important; font-size: 3.5rem !important; line-height: 1.1 !important; font-weight: 800 !important; opacity: 1 !important; visibility: visible !important; display: block !important;">Your neighborhood,<br>safer together.</h1>
                    <p class="mb-6 text-gray-200" style="font-size: 1.25rem; opacity: 0.9; max-width: 500px;">Report local incidents, coordinate with neighbors, and receive safety alerts in real-time.</p>
                    
                    <!-- Live Stats -->
                    <div class="mb-8 text-sm font-mono opacity-80">
                        <div class="mb-3 flex items-center">
                            <div class="w-2 h-2 rounded-full bg-terracotta pulse-border mr-2" style="background-color: #E07A5F;"></div>
                            <span class="count-up" data-target="312">0</span>&nbsp;<span>incidents reported</span>
                        </div>
                        <div class="mb-3 flex items-center">
                            <div class="w-2 h-2 rounded-full bg-olive mr-2" style="background-color: #8A9A5B;"></div>
                            <span class="count-up" data-target="287">0</span>&nbsp;<span>resolved</span>
                        </div>
                        <div class="mb-3 flex items-center">
                            <div class="w-2 h-2 rounded-full bg-amber mr-2" style="background-color: #FFBF00;"></div>
                            <span class="count-up" data-target="12">0</span>&nbsp;<span>active zones</span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('register') }}" class="btn-primary inline-block" style="font-size: 1.1rem; padding: 1rem 2rem;">Join SafeNeighbor</a>
                        <a href="{{ route('login') }}" class="btn-secondary text-cream inline-block" style="border-color: var(--color-cream); font-size: 1.1rem; padding: 1rem 2rem;">Log In</a>
                    </div>
                </div>

                <!-- Right Content (Floating Shield) -->
                <div class="md:w-2/5 flex justify-center hidden md:flex">
                    <svg class="floating-shield" width="280" height="280" viewBox="0 0 24 24" fill="none" stroke="var(--color-terracotta)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M12 8v4"/>
                        <path d="M12 16h.01"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Marquee Ticker -->
        <div class="absolute bottom-0 left-0 w-full bg-charcoal bg-opacity-40 text-cream py-2 overflow-hidden border-t border-white border-opacity-10">
            <div class="marquee-content whitespace-nowrap text-sm font-mono tracking-wide">
                <span>LATEST: Chain snatching reported in Model Town &nbsp; &middot; &nbsp; Gas leak resolved in Lajpat Nagar &nbsp; &middot; &nbsp; New warden assigned to Civil Lines zone &nbsp; &middot; &nbsp; LATEST: Chain snatching reported in Model Town &nbsp; &middot; &nbsp; Gas leak resolved in Lajpat Nagar &nbsp; &middot; &nbsp; New warden assigned to Civil Lines zone &nbsp; &middot; &nbsp; LATEST: Chain snatching reported in Model Town &nbsp; &middot; &nbsp; Gas leak resolved in Lajpat Nagar &nbsp; &middot; &nbsp; New warden assigned to Civil Lines zone &nbsp; &middot; &nbsp;</span>
            </div>
        </div>
    </div>

    <!-- How it works -->
    <div class="container py-16">
        <h2 class="font-heading text-center mb-12" style="font-size: 2.5rem;">How it works</h2>
        
        <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div class="text-center">
                <div style="width: 80px; height: 80px; background-color: var(--color-sand); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--color-terracotta)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <h3 class="font-heading" style="font-size: 1.5rem;">Report</h3>
                <p>Quickly report incidents like theft, fire, or suspicious activity in your area.</p>
            </div>
            
            <div class="text-center">
                <div style="width: 80px; height: 80px; background-color: var(--color-sand); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--color-terracotta)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="font-heading" style="font-size: 1.5rem;">Review</h3>
                <p>Wardens and law enforcement review reports and verify information.</p>
            </div>
            
            <div class="text-center">
                <div style="width: 80px; height: 80px; background-color: var(--color-sand); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="var(--color-terracotta)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                </div>
                <h3 class="font-heading" style="font-size: 1.5rem;">Resolve</h3>
                <p>Track the status of incidents as they are handled and resolved.</p>
            </div>
        </div>
    </div>

    <!-- Key Features -->
    <div style="background-color: #1a202c; padding: 5rem 0; color: #ffffff;">
        <div class="container" style="max-width: 72rem; margin: 0 auto; padding: 0 1rem;">
            <h2 class="font-heading text-center" style="font-size: 2.25rem; margin-bottom: 3rem; font-weight: bold; color: #ffffff !important;">Key Features</h2>
            
            <div style="display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
                <!-- Feature 1 -->
                <div style="background-color: #2A3B4C; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05);">
                    <h3 class="font-heading" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #ffffff !important;">Interactive Dashboard</h3>
                    <p style="color: #cbd5e1 !important; line-height: 1.625; font-size: 0.875rem;">
                        Get a complete overview of your local zone. The dashboard shows real-time safety scores, open incidents, and quick stats for your specific locality so you always know exactly what's happening around you. Admins and wardens can monitor the pulse of the community at a glance.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div style="background-color: #2A3B4C; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05);">
                    <h3 class="font-heading" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #ffffff !important;">Incident Heatmap</h3>
                    <p style="color: #cbd5e1 !important; line-height: 1.625; font-size: 0.875rem;">
                        Visualize safety in your city. The interactive incident heatmap plots active reports across the region, color-coded by severity (from low to critical), allowing you to easily identify hotspots, understand local trends, and avoid high-risk areas during your daily commute.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div style="background-color: #2A3B4C; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05);">
                    <h3 class="font-heading" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #ffffff !important;">Hyper-Local Feed</h3>
                    <p style="color: #cbd5e1 !important; line-height: 1.625; font-size: 0.875rem;">
                        Stay connected with your immediate neighbors. Switch seamlessly between city-wide news and hyper-local updates specific to your registered society or colony. This ensures the information you see is always highly relevant to your immediate surroundings and daily life.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div style="background-color: #2A3B4C; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.05);">
                    <h3 class="font-heading" style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #ffffff !important;">Community Collaboration</h3>
                    <p style="color: #cbd5e1 !important; line-height: 1.625; font-size: 0.875rem;">
                        Work together to resolve issues effectively. Participate in local polls to voice your opinion, read important announcements from your community wardens, and give kudos to top reporters who are actively keeping your neighborhood safe and secure for everyone.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial -->
    <div class="bg-cream py-16" style="border-top: 1px dashed var(--color-sand);">
        <div class="container text-center">
            <p class="font-heading text-navy mx-auto" style="font-size: 2rem; max-width: 800px; line-height: 1.4;">"SafeNeighbor has completely transformed how our community handles safety. We feel more connected and secure than ever before."</p>
            <p class="mt-4 font-bold">— Sarah T., Westside Patrol Zone</p>
        </div>
    </div>
</x-app-layout>
