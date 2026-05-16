<x-app-layout>
    <div class="container py-8 max-w-3xl">
        <h1 class="font-heading text-navy text-3xl mb-8">Notifications</h1>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-sand">
            @if($notifications->count() > 0)
                <div class="p-4 border-b border-sand bg-cream flex justify-between items-center">
                    <span class="font-bold">You have {{ auth()->user()->unreadNotifications->count() }} unread</span>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('notifications.markAllRead') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-secondary text-sm py-1 px-3">Mark all read</button>
                        </form>
                    @endif
                </div>

                <div class="divide-y divide-sand">
                    @foreach($notifications as $notification)
                        <div class="p-4 {{ $notification->read_at ? 'opacity-70 bg-white' : 'bg-cream bg-opacity-30' }} flex gap-4 transition hover:bg-cream">
                            <div class="flex-shrink-0 mt-1">
                                @if($notification->type === 'App\Notifications\EmergencyAlertNotification')
                                    <div class="w-10 h-10 rounded-full bg-rose text-white flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                    </div>
                                @elseif($notification->type === 'App\Notifications\StatusUpdateNotification')
                                    <div class="w-10 h-10 rounded-full bg-olive text-white flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-amber text-white flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1">
                                <h4 class="font-bold text-navy m-0">
                                    @if(isset($notification->data['incident_id']))
                                        <a href="{{ route('incidents.show', $notification->data['incident_id']) }}" class="text-navy hover:underline">{{ $notification->data['message'] }}</a>
                                    @elseif(isset($notification->data['announcement_id']))
                                        <a href="{{ route('announcements.show', $notification->data['announcement_id']) }}" class="text-navy hover:underline">{{ $notification->data['message'] }}</a>
                                    @else
                                        {{ $notification->data['message'] }}
                                    @endif
                                </h4>
                                @if(isset($notification->data['details']))
                                    <p class="text-sm opacity-80 mt-1 mb-0">{{ $notification->data['details'] }}</p>
                                @endif
                                <div class="text-xs font-mono opacity-60 mt-2" data-timestamp="{{ $notification->created_at->toIso8601String() }}">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>

                            @if(!$notification->read_at)
                                <div class="flex-shrink-0 flex items-center">
                                    <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-3 h-3 rounded-full bg-terracotta border-none cursor-pointer" title="Mark as read"></button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center opacity-70">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mx-auto mb-4 text-sand"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    <p class="text-xl m-0">You're all caught up!</p>
                </div>
            @endif
        </div>
        
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
