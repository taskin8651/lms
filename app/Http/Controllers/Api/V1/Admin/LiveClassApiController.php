<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreLiveClassRequest;
use App\Http\Requests\UpdateLiveClassRequest;
use App\Http\Resources\Admin\LiveClassResource;
use App\Models\LiveClass;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LiveClassApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('live_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LiveClassResource(LiveClass::with(['batch', 'teacher'])->get());
    }

    public function store(StoreLiveClassRequest $request)
    {
        $liveClass = LiveClass::create($request->all());

        if ($request->input('photo', false)) {
            $liveClass->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        return (new LiveClassResource($liveClass))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(LiveClass $liveClass)
    {
        abort_if(Gate::denies('live_class_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LiveClassResource($liveClass->load(['batch', 'teacher']));
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

        return (new LiveClassResource($liveClass))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(LiveClass $liveClass)
    {
        abort_if(Gate::denies('live_class_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $liveClass->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
