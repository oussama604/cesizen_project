<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\View\View;

class InformationController extends \App\Http\Controllers\Controller
{
    public function index(): View
    {
        $contents = Content::query()
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(9);

        return view('information.index', [
            'contents' => $contents,
        ]);
    }

    public function show(string $slug): View
    {
        $content = Content::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('information.show', [
            'content' => $content,
        ]);
    }
}
