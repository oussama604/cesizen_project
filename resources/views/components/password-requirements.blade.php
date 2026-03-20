@php($requirements = \App\Support\PasswordPolicy::requirements())

<div class="mt-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
    <p class="font-medium text-slate-900">Exigences du mot de passe</p>
    <ul class="mt-2 list-disc space-y-1 pl-5">
        @foreach ($requirements as $requirement)
            <li>{{ $requirement }}</li>
        @endforeach
    </ul>
</div>