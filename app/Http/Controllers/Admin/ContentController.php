<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Content::class);

        $contents = Content::query()
            ->with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.contents.index', [
            'contents' => $contents,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Content::class);

        return view('admin.contents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Content::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['title']);
        $baseSlug = $slug;
        $counter = 1;

        while (Content::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        Content::create([
            ...$validated,
            'slug' => $slug,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? Carbon::now() : null,
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.contents.index')->with('status', 'Contenu cree avec succes.');
    }

    public function edit(Content $content): View
    {
        Gate::authorize('update', $content);

        return view('admin.contents.edit', [
            'content' => $content,
        ]);
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        Gate::authorize('update', $content);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($validated['title'] !== $content->title) {
            $slug = Str::slug($validated['title']);
            $baseSlug = $slug;
            $counter = 1;

            while (Content::query()->where('slug', $slug)->where('id', '!=', $content->id)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        $isPublished = $request->boolean('is_published');

        $content->update([
            ...$validated,
            'is_published' => $isPublished,
            'published_at' => $isPublished ? ($content->published_at ?? Carbon::now()) : null,
            'updated_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.contents.index')->with('status', 'Contenu mis a jour.');
    }

    public function destroy(Content $content): RedirectResponse
    {
        Gate::authorize('delete', $content);

        $content->delete();

        return redirect()->route('admin.contents.index')->with('status', 'Contenu supprime.');
    }
}
