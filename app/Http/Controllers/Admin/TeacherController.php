<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTeacherRequest;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TeacherController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('teacher_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teachers = Teacher::with(['user', 'media'])->get();

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        abort_if(Gate::denies('teacher_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.teachers.create', compact('users'));
    }

    public function store(StoreTeacherRequest $request)
    {
        $teacher = Teacher::create($request->all());

        if ($request->input('profile', false)) {
            $teacher->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
        }

        foreach ($request->input('document', []) as $file) {
            $teacher->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $teacher->id]);
        }

        return redirect()->route('admin.teachers.index');
    }

    public function edit(Teacher $teacher)
    {
        abort_if(Gate::denies('teacher_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teacher->load('user');

        return view('admin.teachers.edit', compact('teacher', 'users'));
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        $teacher->update($request->all());

        if ($request->input('profile', false)) {
            if (! $teacher->profile || $request->input('profile') !== $teacher->profile->file_name) {
                if ($teacher->profile) {
                    $teacher->profile->delete();
                }
                $teacher->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile'))))->toMediaCollection('profile');
            }
        } elseif ($teacher->profile) {
            $teacher->profile->delete();
        }

        if (count($teacher->document) > 0) {
            foreach ($teacher->document as $media) {
                if (! in_array($media->file_name, $request->input('document', []))) {
                    $media->delete();
                }
            }
        }
        $media = $teacher->document->pluck('file_name')->toArray();
        foreach ($request->input('document', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $teacher->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document');
            }
        }

        return redirect()->route('admin.teachers.index');
    }

    public function show(Teacher $teacher)
    {
        abort_if(Gate::denies('teacher_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teacher->load('user');

        return view('admin.teachers.show', compact('teacher'));
    }

    public function destroy(Teacher $teacher)
    {
        abort_if(Gate::denies('teacher_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teacher->delete();

        return back();
    }

    public function massDestroy(MassDestroyTeacherRequest $request)
    {
        $teachers = Teacher::find(request('ids'));

        foreach ($teachers as $teacher) {
            $teacher->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('teacher_create') && Gate::denies('teacher_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Teacher();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
