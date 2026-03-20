@csrf

<div>
    <x-input-label for="label" value="Question / evenement" />
    <x-text-input id="label" name="label" type="text" class="mt-1 block w-full" :value="old('label', $stressEvent->label ?? '')" required />
    <x-input-error :messages="$errors->get('label')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="score" value="Score" />
    <x-text-input id="score" name="score" type="number" min="0" class="mt-1 block w-full" :value="old('score', $stressEvent->score ?? '')" required />
    <x-input-error :messages="$errors->get('score')" class="mt-2" />
</div>

<div class="mt-4 flex items-center gap-2">
    <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" @checked(old('is_active', $stressEvent->is_active ?? true))>
    <label for="is_active" class="text-sm text-gray-700">Question active</label>
</div>

<div class="mt-6">
    <x-primary-button>{{ $buttonLabel }}</x-primary-button>
</div>
