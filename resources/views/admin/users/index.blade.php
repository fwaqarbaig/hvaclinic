@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="space-y-6" x-data="{
    deleteModalOpen: false,
    selectedUser: null,
    deleteOption: 'reassign',
    reassignUserId: '{{ auth()->id() }}',
    actionUrl: '',
    openDeleteModal(user, url) {
        this.selectedUser = user;
        this.actionUrl = url;
        this.deleteOption = 'reassign';
        this.reassignUserId = '{{ auth()->id() }}';
        if (this.selectedUser && Number(this.selectedUser.id) === Number(this.reassignUserId)) {
            @php
                $otherAdmin = $eligibleAdmins->firstWhere('id', '!=', auth()->id());
            @endphp
            this.reassignUserId = '{{ $otherAdmin ? $otherAdmin->id : auth()->id() }}';
        }
        this.deleteModalOpen = true;
        this.$nextTick(() => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    },
    closeDeleteModal() {
        this.deleteModalOpen = false;
        this.selectedUser = null;
    }
}">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>Users</span>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-700">{{ $users->total() }}</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Manage user accounts, roles, authors, and publishing privileges</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold shadow-md shadow-brand-500/20 transition self-start sm:self-auto">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Add New User
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2 w-full md:w-auto text-xs">
            <a href="{{ route('admin.users.index') }}" 
               class="px-3 py-1.5 rounded-lg transition {{ empty($role) ? 'bg-slate-900 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">All</a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $role === 'admin' ? 'bg-brand-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">Administrators</a>
            <a href="{{ route('admin.users.index', ['role' => 'editor']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $role === 'editor' ? 'bg-brand-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">Editors</a>
            <a href="{{ route('admin.users.index', ['role' => 'author']) }}" 
               class="px-3 py-1.5 rounded-lg transition {{ $role === 'author' ? 'bg-brand-600 text-white font-semibold' : 'text-slate-600 hover:bg-slate-100' }}">Authors</a>
        </div>

        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-60">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..."
                       class="w-full pl-8 pr-3 py-1.5 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <i data-lucide="search" class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5"></i>
            </div>
            <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl">Search</button>
            @if($search)
                <a href="{{ route('admin.users.index') }}" class="text-xs text-rose-600 hover:underline">Reset</a>
            @endif
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4">User</th>
                    <th class="py-3 px-4">Role</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-center">Posts Written</th>
                    <th class="py-3 px-4">Joined Date</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover border border-slate-200">
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">{{ $user->name }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            @if($user->role === 'admin')
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-purple-100 text-purple-700 border border-purple-200">Admin</span>
                            @elseif($user->role === 'editor')
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-sky-100 text-brand-700 border border-sky-200">Editor</span>
                            @else
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase bg-slate-100 text-slate-700 border border-slate-200">Author</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1 text-[11px] font-medium text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-medium text-rose-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Disabled
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-center font-bold">
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px]">{{ $user->posts_count }}</span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 text-slate-400 hover:text-brand-600 hover:bg-slate-100 rounded-lg transition" title="Edit User">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <button type="button" 
                                            @click="openDeleteModal({
                                                id: {{ $user->id }},
                                                name: '{{ addslashes($user->name) }}',
                                                email: '{{ addslashes($user->email) }}',
                                                role: '{{ $user->role }}',
                                                posts_count: {{ $user->posts_count }},
                                                pages_count: {{ $user->pages_count ?? 0 }}
                                            }, '{{ route('admin.users.destroy', $user) }}')"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" 
                                            title="Delete User">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- WordPress-Style User Deletion & Content Attribution Modal -->
    <div x-cloak x-show="deleteModalOpen" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         @keydown.escape.window="closeDeleteModal()">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background backdrop -->
            <div x-show="deleteModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                 @click="closeDeleteModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="deleteModalOpen" 
                 x-transition:enter="ease-out duration-200" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-150" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
                
                <form :action="actionUrl" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 border border-rose-100">
                                <i data-lucide="user-x" class="w-6 h-6"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-slate-900" id="modal-title">
                                    Delete User: <span class="text-rose-600" x-text="selectedUser?.name"></span>
                                </h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    You have specified this user for deletion. What should be done with content owned by this user?
                                </p>
                            </div>
                        </div>

                        <!-- Content summary badge -->
                        <div class="mt-5 p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs text-slate-600 flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-slate-400 flex-shrink-0"></i>
                            <span>
                                Authored content: 
                                <strong class="text-slate-900" x-text="selectedUser?.posts_count ?? 0"></strong> post(s), 
                                <strong class="text-slate-900" x-text="selectedUser?.pages_count ?? 0"></strong> page(s).
                            </span>
                        </div>

                        <div class="mt-5 space-y-3">
                            <!-- Option 1: Attribute content (WordPress Default) -->
                            <label class="flex items-start gap-3 p-3.5 rounded-xl border transition cursor-pointer"
                                   :class="deleteOption === 'reassign' ? 'border-brand-500 bg-brand-50/40 ring-1 ring-brand-500' : 'border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="delete_option" value="reassign" x-model="deleteOption" 
                                       class="mt-1 text-brand-600 focus:ring-brand-500">
                                <div class="flex-1">
                                    <div class="font-bold text-xs text-slate-900">Attribute all content to:</div>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Safely preserves all authored posts and pages by assigning ownership to another administrator or editor.</p>
                                    
                                    <div class="mt-2.5" x-show="deleteOption === 'reassign'">
                                        <select name="reassign_user_id" x-model="reassignUserId" 
                                                class="w-full text-xs rounded-xl border border-slate-300 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-brand-500/20 bg-white">
                                            @foreach($eligibleAdmins as $admin)
                                                <option value="{{ $admin->id }}" 
                                                        :disabled="selectedUser && Number(selectedUser.id) === {{ $admin->id }}"
                                                        {{ $admin->id === auth()->id() ? 'selected' : '' }}>
                                                    {{ $admin->name }} ({{ ucfirst($admin->role) }}{{ $admin->id === auth()->id() ? ' - Current User' : '' }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </label>

                            <!-- Option 2: Delete All Content -->
                            <label class="flex items-start gap-3 p-3.5 rounded-xl border transition cursor-pointer"
                                   :class="deleteOption === 'delete' ? 'border-rose-500 bg-rose-50/40 ring-1 ring-rose-500' : 'border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="delete_option" value="delete" x-model="deleteOption" 
                                       class="mt-1 text-rose-600 focus:ring-rose-500">
                                <div class="flex-1">
                                    <div class="font-bold text-xs text-rose-900">Delete all content</div>
                                    <p class="text-[11px] text-rose-600 mt-0.5">Warning: All posts, pages, and media created by this user will be permanently deleted and cannot be recovered.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex items-center justify-end gap-3">
                        <button type="button" @click="closeDeleteModal()" 
                                class="px-4 py-2 text-xs font-semibold rounded-xl text-slate-700 hover:bg-slate-200 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-xs font-bold rounded-xl text-white shadow-sm transition"
                                :class="deleteOption === 'delete' ? 'bg-rose-600 hover:bg-rose-700' : 'bg-brand-600 hover:bg-brand-700'">
                            <span x-text="deleteOption === 'delete' ? 'Delete User & All Content' : 'Confirm Deletion & Reattribute Content'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
