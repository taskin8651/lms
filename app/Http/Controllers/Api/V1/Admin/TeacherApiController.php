<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Http\Resources\Admin\TeacherResource;
use App\Models\Teacher;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('teacher_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TeacherResource(Teacher::with(['user'])->get());
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

        return (new TeacherResource($teacher))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Teacher $teacher)
    {
        abort_if(Gate::denies('teacher_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TeacherResource($teacher->load(['user']));
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

        return (new TeacherResource($teacher))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Teacher $teacher)
    {
        abort_if(Gate::denies('teacher_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teacher->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
