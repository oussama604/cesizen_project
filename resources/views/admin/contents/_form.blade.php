@csrf

<div>
    <x-input-label for="title" value="Titre" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $content->title ?? '')" required />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="body" value="Contenu" />
    <textarea id="body" name="body" rows="10" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('body', $content->body ?? '') }}</textarea>
    <x-input-error :messages="$errors->get('body')" class="mt-2" />
</div>

<div class="mt-4 flex items-center gap-2">
    <input id="is_published" name="is_published" type="checkbox" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" @checked(old('is_published', $content->is_published ?? false))>
    <label for="is_published" class="text-sm text-gray-700">Publier immediatement</label>
</div>

<div class="mt-6">
    <x-primary-button>{{ $buttonLabel }}</x-primary-button>
</div>
