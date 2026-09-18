@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-oidp-dark">Base de Questions</h2>
            <p class="text-gray-500 text-sm">{{ $questions->count() }} questions enregistrées</p>
        </div>
        <a href="{{ route('admin.index') }}" class="text-oidp-orange hover:underline font-medium">← Statistiques Candidats</a>
    </div>

    <div class="space-y-3">
        @foreach($questions as $index => $question)
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 {{ $question->type === 'boolean' ? 'border-oidp-blue' : 'border-oidp-orange' }}">
            <div class="flex items-start">
                <span class="flex-shrink-0 text-xs font-bold px-2 py-1 rounded-full mr-3 mt-0.5
                    {{ $question->type === 'boolean' ? 'bg-blue-100 text-oidp-blue' : 'bg-orange-100 text-oidp-orange' }}">
                    {{ $question->type === 'boolean' ? 'V/F' : 'QCM' }}
                </span>
                <div class="flex-1">
                    <h3 class="font-medium text-oidp-dark text-sm mb-2">{{ $index + 1 }}. {{ $question->content }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($question->options as $option)
                            <span class="text-xs px-2 py-1 rounded {{ $option->is_correct ? 'bg-green-100 text-green-700 font-bold' : 'bg-gray-100 text-gray-600' }}">
                                {{ $option->content }}
                                @if($option->is_correct) ✓ @endif
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
