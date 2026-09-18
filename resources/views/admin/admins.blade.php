@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-oidp-dark">Gestion des Administrateurs</h2>
            <p class="text-gray-500 text-sm">{{ $admins->count() }} administrateur(s) enregistré(s)</p>
        </div>
        <a href="{{ route('admin.index') }}" class="text-oidp-orange hover:underline font-medium">← Tableau de bord</a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Add New Admin Form --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border-t-4 border-oidp-orange">
        <h3 class="text-lg font-bold text-oidp-dark mb-4">Ajouter un administrateur</h3>

        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nom complet</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-oidp-orange transition"
                        placeholder="Ex: Amadou Diallo">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-oidp-orange transition"
                        placeholder="admin@oidp.org">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mot de passe</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-oidp-orange transition"
                        placeholder="Min. 6 caractères">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-oidp-orange transition"
                        placeholder="Répétez le mot de passe">
                </div>
            </div>
            <button type="submit" class="bg-oidp-orange hover:bg-oidp-orange-dark text-white font-bold py-2.5 px-6 rounded-lg transition shadow-md">
                + Ajouter l'administrateur
            </button>
        </form>
    </div>

    {{-- Admin List --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-oidp-dark text-white">
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nom</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Créé le</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $i => $admin)
                    <tr class="hover:bg-orange-50 transition">
                        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm font-bold text-oidp-dark">
                            {{ $admin->name }}
                            @if($admin->id === auth()->id())
                                <span class="ml-2 text-xs bg-oidp-orange text-white px-2 py-0.5 rounded-full">Vous</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-600">{{ $admin->email }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-500">{{ $admin->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm text-center">
                            @if($admin->id !== auth()->id())
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Supprimer cet administrateur ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-bold transition">
                                        Supprimer
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
