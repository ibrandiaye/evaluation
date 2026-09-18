@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-oidp-dark">Tableau de bord</h2>
            <p class="text-gray-500 text-sm">Résultats et statistiques des candidats</p>
        </div>
        <a href="{{ route('admin.questions') }}" class="bg-oidp-blue hover:bg-oidp-blue-dark text-white px-4 py-2 rounded-lg font-medium transition">
            📋 Voir les Questions
        </a>
    </div>

    {{-- Stats Cards --}}
    @php
        $totalCandidates = $evaluations->count();
        $avgScore = $totalCandidates > 0 ? $evaluations->avg(fn($e) => $e->total_questions > 0 ? ($e->score / $e->total_questions) * 100 : 0) : 0;
        $passed = $evaluations->filter(fn($e) => $e->total_questions > 0 && ($e->score / $e->total_questions) >= 0.5)->count();
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-oidp-orange">
            <p class="text-gray-500 text-sm">Total Candidats</p>
            <p class="text-3xl font-black text-oidp-dark">{{ $totalCandidates }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-oidp-blue">
            <p class="text-gray-500 text-sm">Moyenne Générale</p>
            <p class="text-3xl font-black text-oidp-blue">{{ number_format($avgScore, 0) }}%</p>
        </div>
        <div class="bg-white rounded-xl shadow p-5 border-l-4 border-green-500">
            <p class="text-gray-500 text-sm">Réussite (≥ 50%)</p>
            <p class="text-3xl font-black text-green-600">{{ $passed }} / {{ $totalCandidates }}</p>
        </div>
    </div>

    {{-- Candidates Table --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-oidp-dark text-white">
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Candidat</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Score</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Pourcentage</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider">Date</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($evaluations as $i => $evaluation)
                    @php
                        $percentage = $evaluation->total_questions > 0 ? ($evaluation->score / $evaluation->total_questions) * 100 : 0;
                    @endphp
                    <tr class="hover:bg-orange-50 transition">
                        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm font-bold text-oidp-dark">{{ $evaluation->participant_name }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm">{{ $evaluation->score }} / {{ $evaluation->total_questions }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $percentage >= 50 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ number_format($percentage, 0) }}%
                            </span>
                        </td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm text-gray-500">{{ $evaluation->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-5 py-4 border-b border-gray-200 text-sm text-center">
                            <a href="{{ route('admin.show', $evaluation->id) }}" class="bg-oidp-orange hover:bg-oidp-orange-dark text-white px-3 py-1 rounded text-xs font-bold transition">
                                Voir détails
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                            Aucune évaluation pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
