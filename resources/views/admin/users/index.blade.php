<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-heading text-navy text-3xl m-0">User Management</h2>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-sand mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm opacity-80 mb-1">Status</label>
                <select name="status" class="py-2 px-3 border border-sand rounded-md">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>
            <div>
                <label class="block text-sm opacity-80 mb-1">Role</label>
                <select name="role" class="py-2 px-3 border border-sand rounded-md">
                    <option value="">All</option>
                    <option value="resident" {{ request('role') === 'resident' ? 'selected' : '' }}>Resident</option>
                    <option value="warden" {{ request('role') === 'warden' ? 'selected' : '' }}>Warden</option>
                    <option value="law_enforcement" {{ request('role') === 'law_enforcement' ? 'selected' : '' }}>Law Enforcement</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn-secondary py-2 px-4">Filter</button>
            @if(request()->anyFilled(['status', 'role', 'zone_id']))
                <a href="{{ route('admin.users.index') }}" class="text-rose text-sm hover:underline">Clear</a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-sand overflow-x-auto">
        <table class="w-full text-left" style="min-width: 800px;">
            <thead>
                <tr class="border-b border-sand bg-cream">
                    <th class="p-4 font-bold uppercase text-xs opacity-70">User</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Contact</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Zone</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Role</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70">Status</th>
                    <th class="p-4 font-bold uppercase text-xs opacity-70 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand">
                @forelse($users as $user)
                    <tr class="hover:bg-cream hover:bg-opacity-30 transition">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-navy text-cream flex items-center justify-center font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-navy">{{ $user->name }}</div>
                                    <div class="text-xs opacity-70 font-mono">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm"><a href="mailto:{{ $user->email }}" class="text-terracotta hover:underline">{{ $user->email }}</a></div>
                            @if($user->phone)
                                <div class="text-xs opacity-70">{{ $user->phone }}</div>
                            @endif
                        </td>
                        <td class="p-4 text-sm font-medium">
                            {{ $user->zone ? $user->zone->name : 'Unassigned' }}
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="py-1 px-2 text-sm border-sand rounded bg-white" onchange="this.form.submit()">
                                    <option value="resident" {{ $user->role === 'resident' ? 'selected' : '' }}>Resident</option>
                                    <option value="warden" {{ $user->role === 'warden' ? 'selected' : '' }}>Warden</option>
                                    <option value="law_enforcement" {{ $user->role === 'law_enforcement' ? 'selected' : '' }}>Law Enf.</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-4">
                            @if($user->is_approved)
                                <span class="bg-olive text-white px-2 py-1 rounded-full text-xs font-bold">Approved</span>
                            @else
                                <span class="bg-amber text-charcoal px-2 py-1 rounded-full text-xs font-bold">Pending</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                @if(!$user->is_approved)
                                    <form action="{{ route('admin.users.approve', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-primary py-1 px-3 text-xs">Approve</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose border-none bg-transparent hover:underline cursor-pointer text-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center opacity-70">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-admin-layout>
