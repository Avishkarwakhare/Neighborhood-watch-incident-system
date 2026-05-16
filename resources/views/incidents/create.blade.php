<x-app-layout>
    <div class="container py-8 max-w-3xl">
        <h1 class="font-heading text-navy text-3xl mb-2">Report an Incident</h1>
        <p class="opacity-80 mb-8">Please provide as much detail as possible to help your neighbors and law enforcement.</p>

        <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data" class="card-handcrafted" x-data="{
            isAnonymous: false,
            lat: '',
            lng: '',
            locating: false,
            getLocation() {
                this.locating = true;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.lat = position.coords.latitude;
                            this.lng = position.coords.longitude;
                            this.locating = false;
                            alert('Location captured successfully!');
                        },
                        (error) => {
                            this.locating = false;
                            alert('Could not get location. Please allow location access or type it manually.');
                        }
                    );
                } else {
                    this.locating = false;
                    alert('Geolocation is not supported by this browser.');
                }
            }
        }">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Incident Title <span class="text-rose">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., Stolen Bicycle on Elm St">
                @error('title')<span class="text-rose text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Category <span class="text-rose">*</span></label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        @foreach(['theft', 'fire', 'accident', 'suspicious_activity', 'vandalism', 'medical', 'natural_disaster', 'other'] as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                        @endforeach
                    </select>
                    @error('category')<span class="text-rose text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block font-medium mb-1">Severity <span class="text-rose">*</span></label>
                    <select name="severity" required>
                        <option value="">Select Severity</option>
                        <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>Low - Non-urgent</option>
                        <option value="medium" {{ old('severity') === 'medium' ? 'selected' : '' }}>Medium - Needs attention</option>
                        <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>High - Urgent</option>
                        <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical - Immediate danger</option>
                    </select>
                    @error('severity')<span class="text-rose text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Description <span class="text-rose">*</span></label>
                <textarea name="description" rows="5" required placeholder="Describe what happened...">{{ old('description') }}</textarea>
                @error('description')<span class="text-rose text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4 bg-sand bg-opacity-20 p-4 rounded-lg">
                <label class="block font-medium mb-1">Location Address <span class="text-rose">*</span></label>
                <input type="text" name="location_address" value="{{ old('location_address') }}" required placeholder="Street address or intersection">
                @error('location_address')<span class="text-rose text-sm">{{ $message }}</span>@enderror
                
                <div class="mt-2 flex gap-4 items-center">
                    <button type="button" @click="getLocation()" class="btn-secondary text-sm py-1 px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'spinner': locating}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span x-text="locating ? 'Locating...' : 'Use Current Location'"></span>
                    </button>
                    <input type="hidden" name="latitude" x-model="lat">
                    <input type="hidden" name="longitude" x-model="lng">
                    <span x-show="lat && lng" class="text-sm text-olive flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>
                        GPS Acquired
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Attach Media (Images, Video) - Max 10MB</label>
                <input type="file" name="media[]" multiple accept="image/*,video/*" class="p-2 bg-cream">
                @error('media.*')<span class="text-rose text-sm block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6 bg-cream p-4 rounded-lg flex gap-3 items-start border border-sand">
                <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" x-model="isAnonymous" class="mt-1">
                <div>
                    <label for="is_anonymous" class="font-bold cursor-pointer text-charcoal">Report Anonymously</label>
                    <p class="text-sm opacity-80 m-0">Your name and avatar will be hidden from the public feed, but wardens and law enforcement will still be able to verify your identity to prevent abuse.</p>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('incidents.index') }}" class="btn-secondary" style="border:none;">Cancel</a>
                <button type="submit" class="btn-primary">Submit Report</button>
            </div>
        </form>
    </div>
</x-app-layout>
