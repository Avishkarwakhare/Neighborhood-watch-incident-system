<x-app-layout>
    <div class="container py-8 max-w-2xl">
        <h1 class="font-heading text-navy text-3xl mb-8">Post Announcement</h1>

        <form action="{{ route('announcements.store') }}" method="POST" class="card-handcrafted bg-white">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Title <span class="text-rose">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g., Road Closure on 5th Ave">
                @error('title')<span class="text-rose text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Priority <span class="text-rose">*</span></label>
                <select name="priority" required>
                    <option value="normal" {{ old('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    <option value="emergency" {{ old('priority') === 'emergency' ? 'selected' : '' }}>Emergency (Sends immediate alerts)</option>
                </select>
                @error('priority')<span class="text-rose text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block font-medium mb-1">Announcement Body <span class="text-rose">*</span></label>
                <textarea name="body" rows="6" required placeholder="Details of the announcement...">{{ old('body') }}</textarea>
                @error('body')<span class="text-rose text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('announcements.index') }}" class="btn-secondary" style="border:none;">Cancel</a>
                <button type="submit" class="btn-primary">Post Announcement</button>
            </div>
        </form>
    </div>
</x-app-layout>
