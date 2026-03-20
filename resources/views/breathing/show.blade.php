<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cesi-green-700 leading-tight">Respiration guidée</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            <div
                x-data="{
                    running: false,
                    phase: 'inspire',
                    secondsLeft: {{ $exercise->default_total_seconds }},
                    phaseSecondsLeft: {{ $exercise->inhale_seconds }},
                    inhale: {{ $exercise->inhale_seconds }},
                    exhale: {{ $exercise->exhale_seconds }},
                    totalDuration: {{ $exercise->default_total_seconds }},
                    intervalRef: null,

                    start() {
                        if (this.running) return;
                        this.running = true;
                        this.secondsLeft = this.totalDuration;
                        this.phase = 'inspire';
                        this.phaseSecondsLeft = this.inhale;
                        this.intervalRef = setInterval(() => {
                            this.secondsLeft--;
                            this.phaseSecondsLeft--;
                            if (this.phaseSecondsLeft <= 0) {
                                this.phase = this.phase === 'inspire' ? 'expire' : 'inspire';
                                this.phaseSecondsLeft = this.phase === 'inspire' ? this.inhale : this.exhale;
                            }
                            if (this.secondsLeft <= 0) {
                                this.finish();
                            }
                        }, 1000);
                    },

                    stop() {
                        if (!this.running) return;
                        this.running = false;
                        clearInterval(this.intervalRef);
                        this.intervalRef = null;
                        this.secondsLeft = this.totalDuration;
                        this.phase = 'inspire';
                        this.phaseSecondsLeft = this.inhale;
                    },

                    finish() {
                        clearInterval(this.intervalRef);
                        this.intervalRef = null;
                        this.running = false;
                        if (this.$refs.durationInput) {
                            this.$refs.durationInput.value = this.totalDuration;
                        }
                        this.$nextTick(() => {
                            if (this.$refs.saveFormRef) {
                                this.$refs.saveFormRef.submit();
                            }
                        });
                    },

                    formatTime(s) {
                        const m = Math.floor(s / 60);
                        const sec = s % 60;
                        return (m > 0 ? m + 'min ' : '') + (sec < 10 ? '0' : '') + sec + 's';
                    }
                }"
                class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
            >

                {{-- ── En-tête coloré ── --}}
                <div class="bg-gradient-to-r from-cesi-green-500 to-cesi-yellow-400 px-6 py-5 text-white">
                    <h3 class="text-xl font-bold">{{ $exercise->name }}</h3>
                    <div class="mt-2 flex flex-wrap items-center gap-3 text-cesi-yellow-50">
                        <span class="inline-flex items-center gap-1 bg-white/20 rounded-full px-3 py-0.5">
                            ↑ Inspiration : {{ $exercise->inhale_seconds }}s
                        </span>
                        <span class="inline-flex items-center gap-1 bg-white/20 rounded-full px-3 py-0.5">
                            ↓ Expiration : {{ $exercise->exhale_seconds }}s
                        </span>
                        <span class="inline-flex items-center gap-1 bg-white/20 rounded-full px-3 py-0.5">
                            ⏱ Durée : {{ $exercise->default_total_seconds }}s
                        </span>
                    </div>
                </div>

                {{-- ── Corps principal ── --}}
                <div class="px-6 py-8 flex flex-col items-center">

                    {{-- Label de phase --}}
                    <p
                        class="text-2xl font-bold tracking-wide"
                        style="color: #059669; transition: color 0.7s ease;"
                        :style="phase === 'inspire' ? 'color:#059669' : 'color:#0891b2'"
                        x-text="phase === 'inspire' ? 'Inspirez...' : 'Expirez...'"
                    >Inspirez...</p>

                    {{-- Cercle animé --}}
                    <div class="my-8" style="display:flex; align-items:center; justify-content:center; width:210px; height:210px;">
                        <div
                            :style="{
                                width: '160px',
                                height: '160px',
                                borderRadius: '50%',
                                boxShadow: '0 20px 40px rgba(6,182,212,0.4)',
                                willChange: 'transform',
                                background: phase === 'inspire'
                                    ? 'linear-gradient(135deg,#34d399 0%,#059669 100%)'
                                    : 'linear-gradient(135deg,#67e8f9 0%,#0891b2 100%)',
                                transform: !running ? 'scale(1)' : (phase === 'inspire' ? 'scale(1.3)' : 'scale(0.65)'),
                                transition: 'transform ' + (!running ? '0.6' : (phase === 'inspire' ? inhale : exhale) * 0.9) + 's ease-in-out, background 0.8s ease'
                            }"
                        ></div>
                    </div>

                    {{-- Compteur de phase --}}
                    <div class="flex flex-col items-center gap-1">
                        <span
                            class="text-5xl font-mono font-extrabold tabular-nums leading-none transition-colors duration-700"
                            :class="phase === 'inspire' ? 'text-cesi-green-600' : 'text-cesi-yellow-500'"
                            x-text="phaseSecondsLeft"
                        ></span>
                        <span
                            class="text-sm font-medium transition-colors duration-700"
                            :class="phase === 'inspire' ? 'text-cesi-green-500' : 'text-cesi-yellow-400'"
                            x-text="phase === 'inspire' ? 'secondes pour inspirer' : 'secondes pour expirer'"
                        ></span>
                    </div>

                    {{-- Barre de progression totale --}}
                    <div class="mt-6 w-full space-y-1">
                        <div class="flex justify-between text-xs text-gray-400">
                            <span>Progression de la séance</span>
                            <span x-text="formatTime(secondsLeft) + ' restant'"></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5">
                            <div
                                class="h-2.5 rounded-full transition-all duration-1000"
                                :class="phase === 'inspire' ? 'bg-cesi-green-500' : 'bg-cesi-yellow-400'"
                                :style="'width: ' + Math.min(100, Math.round(((totalDuration - secondsLeft) / totalDuration) * 100)) + '%'"
                            ></div>
                        </div>
                    </div>

                    {{-- Boutons --}}
                    <div class="mt-6 flex items-center gap-4">
                        <button
                            type="button"
                            @click="start()"
                            :disabled="running"
                            class="px-8 py-3 rounded-xl font-semibold text-base shadow-lg transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-cesi-yellow-300"
                            :class="running
                                ? 'bg-cesi-green-300 text-white cursor-not-allowed'
                                : 'bg-cesi-green-500 hover:bg-cesi-green-600 active:scale-95 text-white'"
                        >
                            Commencer
                        </button>

                        <button
                            type="button"
                            @click="stop()"
                            :disabled="!running"
                            class="px-8 py-3 rounded-xl font-semibold text-base border-2 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-gray-200"
                            :class="!running
                                ? 'border-gray-200 text-gray-300 cursor-not-allowed'
                                : 'border-gray-300 text-gray-700 hover:border-red-400 hover:text-red-600 hover:bg-red-50 active:scale-95'"
                        >
                            Arrêter
                        </button>
                    </div>
                </div>

                @auth
                    <form x-ref="saveFormRef" method="POST" action="{{ route('breathing.store') }}" class="hidden">
                        @csrf
                        <input type="hidden" name="breathing_exercise_id" value="{{ $exercise->id }}">
                        <input x-ref="durationInput" type="hidden" name="total_duration_seconds" value="{{ $exercise->default_total_seconds }}">
                    </form>
                @endauth

                @guest
                    <div class="mx-6 mb-6 flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-4 py-3 text-sm">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>
                            <a href="{{ route('login') }}" class="font-semibold underline hover:text-amber-900">Connectez-vous</a>
                            pour enregistrer automatiquement vos sessions de respiration.
                        </span>
                    </div>
                @endguest

            </div>{{-- end card --}}
        </div>
    </div>
</x-app-layout>
