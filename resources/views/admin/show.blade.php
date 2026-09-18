@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.index') }}" class="text-oidp-orange hover:underline font-medium">← Retour aux évaluations</a>
    </div>

    {{-- Candidate Summary --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border-l-4 border-oidp-orange">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-xl font-bold text-oidp-dark">{{ $evaluation->participant_name }}</h2>
                <p class="text-gray-500 text-sm">Passé le {{ $evaluation->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            @php
                $percentage = $evaluation->total_questions > 0 ? ($evaluation->score / $evaluation->total_questions) * 100 : 0;
            @endphp
            <div class="mt-4 sm:mt-0 text-center">
                <div class="text-4xl font-black {{ $percentage >= 50 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($percentage, 0) }}%
                </div>
                <p class="text-gray-500 text-sm font-medium">{{ $evaluation->score }} / {{ $evaluation->total_questions }}</p>
            </div>
        </div>
    </div>

    <h3 class="text-lg font-bold text-oidp-dark mb-4">Détail des réponses</h3>

    @foreach($evaluation->answers as $index => $answer)
    <div class="bg-white rounded-xl shadow-sm p-5 mb-3 border-l-4 {{ $answer->is_correct ? 'border-green-500' : 'border-red-500' }}">
        <div class="flex items-start">
            <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3 {{ $answer->is_correct ? 'bg-green-500' : 'bg-red-500' }}">
                {{ $answer->is_correct ? '✓' : '✗' }}
            </span>
            <div class="flex-1">
                <p class="text-oidp-dark font-medium text-sm mb-2">{{ $index + 1 }}. {{ $answer->question->content }}</p>
                <p class="text-sm">
                    <span class="text-gray-500">Réponse :</span>
                    <span class="{{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }} font-medium">{{ $answer->option->content }}</span>
                </p>
                @if(!$answer->is_correct)
                    @php $correctOption = $answer->question->options->where('is_correct', true)->first(); @endphp
                    <p class="text-sm mt-1">
                        <span class="text-gray-500">Bonne réponse :</span>
                        <span class="text-green-600 font-medium">{{ $correctOption ? $correctOption->content : '—' }}</span>
                    </p>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
