<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLiveClassRequest;
use App\Http\Requests\StoreLiveClassRequest;
use App\Http\Requests\UpdateLiveClassRequest;
use App\Models\Batch;
use App\Models\LiveClass;
use App\Models\Teacher;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class LiveClassController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('live_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $liveClasses = LiveClass::with(['batch', 'teacher', 'media'])->get();

        return view('admin.liveClasses.index', compact('liveClasses'));
    }

    public function create()
    {
        abort_if(Gate::denies('live_class_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = Teacher::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.liveClasses.create', compact('batches', 'teachers'));
    }

    public function store(StoreLiveClassRequest $request)
    {
        $liveClass = LiveClass::create($request->all());

        if ($request->input('photo', false)) {
            $liveClass->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $liveClass->id]);
        }

        return redirect()->route('admin.live-classes.index');
    }

    public function edit(LiveClass $liveClass)
    {
        abort_if(Gate::denies('live_class_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $teachers = Teacher::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        $liveClass->load('batch', 'teacher');

        return view('admin.liveClasses.edit', compact('batches', 'liveClass', 'teachers'));
    }

    public function update(UpdateLiveClassRequest $request, LiveClass $liveClass)
    {
        $liveClass->update($request->all());

        if ($request->input('photo', false)) {
            if (! $liveClass->photo || $request->input('photo') !== $liveClass->photo->file_name) {
                if ($liveClass->photo) {
                    $liveClass->photo->delete();
                }
                $liveClass->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($liveClass->photo) {
            $liveClass->photo->delete();
        }

        return redirect()->route('admin.live-classes.index');
    }

    public function show(LiveClass $liveClass)
    {
        abort_if(Gate::denies('live_class_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $liveClass->load('batch', 'teacher');

        return view('admin.liveClasses.show', compact('liveClass'));
    }

    public function destroy(LiveClass $liveClass)
    {
        abort_if(Gate::denies('live_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $liveClass->delete();

        return back();
    }

    public function massDestroy(MassDestroyLiveClassRequest $request)
    {
        $liveClasses = LiveClass::find(request('ids'));

        foreach ($liveClasses as $liveClass) {
            $liveClass->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('live_class_create') && Gate::denies('live_class_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new LiveClass();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
