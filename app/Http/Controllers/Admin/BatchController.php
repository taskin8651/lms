<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBatchRequest;
use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use App\Models\AcademicSession;
use App\Models\Batch;
use App\Models\ClassLevel;
use App\Models\Subject;
use App\Models\Teacher;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BatchController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('batch_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::with(['class_level', 'subject', 'teacher', 'academic_session'])->get();

        return view('admin.batches.index', compact('batches'));
    }

    public function create()
    {
        abort_if(Gate::denies('batch_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $class_levels = ClassLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subjects = Subject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = Teacher::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        $academic_sessions = AcademicSession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.batches.create', compact('academic_sessions', 'class_levels', 'subjects', 'teachers'));
    }

    public function store(StoreBatchRequest $request)
    {
        $batch = Batch::create($request->all());

        return redirect()->route('admin.batches.index');
    }

    public function edit(Batch $batch)
    {
        abort_if(Gate::denies('batch_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $class_levels = ClassLevel::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subjects = Subject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = Teacher::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        $academic_sessions = AcademicSession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $batch->load('class_level', 'subject', 'teacher', 'academic_session');

        return view('admin.batches.edit', compact('academic_sessions', 'batch', 'class_levels', 'subjects', 'teachers'));
    }

    public function update(UpdateBatchRequest $request, Batch $batch)
    {
        $batch->update($request->all());

        return redirect()->route('admin.batches.index');
    }

    public function show(Batch $batch)
    {
        abort_if(Gate::denies('batch_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batch->load('class_level', 'subject', 'teacher', 'academic_session');

        return view('admin.batches.show', compact('batch'));
    }

    public function destroy(Batch $batch)
    {
        abort_if(Gate::denies('batch_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batch->delete();

        return back();
    }

    public function massDestroy(MassDestroyBatchRequest $request)
    {
        $batches = Batch::find(request('ids'));

        foreach ($batches as $batch) {
            $batch->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
