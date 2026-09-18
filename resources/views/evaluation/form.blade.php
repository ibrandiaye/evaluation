@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 border-l-4 border-oidp-orange">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-oidp-dark">Candidat : {{ session('participant_name') }}</h2>
                <p class="text-gray-500 text-sm mt-1">Répondez à chaque question puis passez à l'étape suivante.</p>
            </div>
            <div id="timer" class="text-oidp-blue font-mono text-lg font-bold bg-gray-50 px-3 py-1 rounded-lg">00:00</div>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-600">Progression</span>
            <span id="progressText" class="text-sm font-bold text-oidp-orange">1 / {{ $questions->count() }}</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div id="progressBar" class="bg-gradient-to-r from-oidp-orange to-oidp-blue h-3 rounded-full transition-all duration-500" style="width: {{ 100 / $questions->count() }}%"></div>
        </div>
    </div>

    <form action="{{ route('evaluation.submit') }}" method="POST" id="evaluationForm">
        @csrf

        @foreach($questions as $index => $question)
        <div class="step bg-white rounded-xl shadow-md p-6 mb-6 {{ $index === 0 ? '' : 'hidden' }}" data-step="{{ $index }}">

            {{-- Step indicator --}}
            <div class="flex items-center mb-4">
                <span class="bg-oidp-orange text-white text-xs font-bold px-3 py-1 rounded-full mr-3">
                    {{ $question->type === 'boolean' ? 'VRAI / FAUX' : 'QCM' }}
                </span>
                <span class="text-gray-400 text-sm">Question {{ $index + 1 }} sur {{ $questions->count() }}</span>
            </div>

            <h3 class="text-lg font-semibold text-oidp-dark mb-5 leading-relaxed">
                {{ $question->content }}
            </h3>

            <div class="space-y-3">
                @foreach($question->options as $option)
                <label class="option-label flex items-start cursor-pointer p-4 rounded-lg border-2 border-gray-200 hover:border-oidp-orange hover:bg-orange-50 transition-all group">
                    <div class="flex items-center h-5 mt-0.5">
                        <input type="radio" name="question_{{ $question->id }}" value="{{ $option->id }}" required
                            class="w-5 h-5 text-oidp-orange border-gray-300 focus:ring-oidp-orange">
                    </div>
                    <div class="ml-4">
                        <span class="font-medium text-gray-700 group-hover:text-oidp-dark">
                            @if($question->type === 'multiple_choice' && $option->letter)
                                <span class="inline-block bg-gray-100 text-oidp-dark font-bold rounded-full w-7 h-7 text-center leading-7 mr-2 text-sm">{{ $option->letter }}</span>
                            @endif
                            {{ $option->content }}
                        </span>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- Navigation Buttons --}}
        <div class="flex justify-between mb-8">
            <button type="button" id="prevBtn" onclick="changeStep(-1)"
                class="hidden bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg transition">
                ← Précédent
            </button>
            <div class="flex-1"></div>
            <button type="button" id="nextBtn" onclick="changeStep(1)"
                class="bg-oidp-blue hover:bg-oidp-blue-dark text-white font-bold py-3 px-8 rounded-lg transition shadow-md">
                Suivant →
            </button>
            <button type="submit" id="submitBtn"
                class="hidden bg-oidp-orange hover:bg-oidp-orange-dark text-white font-bold py-3 px-8 rounded-lg transition shadow-md">
                ✓ Soumettre mes réponses
            </button>
        </div>
    </form>
</div>

<script>
    let currentStep = 0;
    const steps = document.querySelectorAll('.step');
    const totalSteps = steps.length;

    // Timer
    let seconds = 0;
    setInterval(() => {
        seconds++;
        const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
        const secs = String(seconds % 60).padStart(2, '0');
        document.getElementById('timer').textContent = mins + ':' + secs;
    }, 1000);

    function changeStep(dir) {
        // If going forward, check if current question is answered
        if (dir === 1) {
            const currentStepEl = steps[currentStep];
            const radios = currentStepEl.querySelectorAll('input[type="radio"]');
            const answered = Array.from(radios).some(r => r.checked);
            if (!answered) {
                // Highlight the question
                currentStepEl.classList.add('ring-2', 'ring-red-400');
                setTimeout(() => currentStepEl.classList.remove('ring-2', 'ring-red-400'), 1500);
                return;
            }
        }

        steps[currentStep].classList.add('hidden');
        currentStep += dir;
        steps[currentStep].classList.remove('hidden');

        // Update progress
        document.getElementById('progressBar').style.width = ((currentStep + 1) / totalSteps * 100) + '%';
        document.getElementById('progressText').textContent = (currentStep + 1) + ' / ' + totalSteps;

        // Toggle buttons
        document.getElementById('prevBtn').classList.toggle('hidden', currentStep === 0);
        document.getElementById('nextBtn').classList.toggle('hidden', currentStep === totalSteps - 1);
        document.getElementById('submitBtn').classList.toggle('hidden', currentStep !== totalSteps - 1);

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Highlight selected option visually
    document.querySelectorAll('.option-label input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function () {
            // Reset all siblings
            this.closest('.space-y-3').querySelectorAll('.option-label').forEach(label => {
                label.classList.remove('border-oidp-orange', 'bg-orange-50');
                label.classList.add('border-gray-200');
            });
            // Highlight selected
            this.closest('.option-label').classList.add('border-oidp-orange', 'bg-orange-50');
            this.closest('.option-label').classList.remove('border-gray-200');
        });
    });

    // Confirm before submit
    document.getElementById('evaluationForm').addEventListener('submit', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir soumettre vos réponses ? Cette action est définitive.')) {
            e.preventDefault();
        }
    });
</script>
@endsection
