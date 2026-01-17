<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyChapterRequest;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Models\Chapter;
use App\Models\Subject;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChapterController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('chapter_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chapters = Chapter::with(['subject'])->get();

        return view('admin.chapters.index', compact('chapters'));
    }

    public function create()
    {
        abort_if(Gate::denies('chapter_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subjects = Subject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.chapters.create', compact('subjects'));
    }

    public function store(StoreChapterRequest $request)
    {
        $chapter = Chapter::create($request->all());

        return redirect()->route('admin.chapters.index');
    }

    public function edit(Chapter $chapter)
    {
        abort_if(Gate::denies('chapter_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subjects = Subject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $chapter->load('subject');

        return view('admin.chapters.edit', compact('chapter', 'subjects'));
    }

    public function update(UpdateChapterRequest $request, Chapter $chapter)
    {
        $chapter->update($request->all());

        return redirect()->route('admin.chapters.index');
    }

    public function show(Chapter $chapter)
    {
        abort_if(Gate::denies('chapter_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chapter->load('subject');

        return view('admin.chapters.show', compact('chapter'));
    }

    public function destroy(Chapter $chapter)
    {
        abort_if(Gate::denies('chapter_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chapter->delete();

        return back();
    }

    public function massDestroy(MassDestroyChapterRequest $request)
    {
        $chapters = Chapter::find(request('ids'));

        foreach ($chapters as $chapter) {
            $chapter->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
