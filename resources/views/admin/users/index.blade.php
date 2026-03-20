<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des utilisateurs</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Nom</th>
                            <th class="px-4 py-3 text-left">Adresse e-mail</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-left">Derniere connexion</th>
                            <th class="px-4 py-3 text-left">Etat</th>
                            <th class="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex items-center gap-2 justify-end">
                                        @csrf
                                        @method('PATCH')

                                        <select name="role_id" class="rounded-md border-gray-300 text-sm">
                                            <option value="">Aucun role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @selected($user->role_id === $role->id)>{{ $role->label }}</option>
                                            @endforeach
                                        </select>
                                </td>
                                <td class="px-4 py-3 text-gray-600">{{ $user->last_login_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <select name="is_active" class="rounded-md border-gray-300 text-sm">
                                        <option value="1" @selected($user->is_active)>Actif</option>
                                        <option value="0" @selected(! $user->is_active)>Desactive</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3 text-right">
                                        <button type="submit" class="text-emerald-700 hover:text-emerald-900">Enregistrer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
