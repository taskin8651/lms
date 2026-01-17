<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCrouselRequest;
use App\Http\Requests\UpdateCrouselRequest;
use App\Http\Resources\Admin\CrouselResource;
use App\Models\Crousel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrouselApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('crousel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrouselResource(Crousel::all());
    }

    public function store(StoreCrouselRequest $request)
    {
        $crousel = Crousel::create($request->all());

        if ($request->input('upload_image', false)) {
            $crousel->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
        }

        return (new CrouselResource($crousel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Crousel $crousel)
    {
        abort_if(Gate::denies('crousel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CrouselResource($crousel);
    }

    public function update(UpdateCrouselRequest $request, Crousel $crousel)
    {
        $crousel->update($request->all());

        if ($request->input('upload_image', false)) {
            if (! $crousel->upload_image || $request->input('upload_image') !== $crousel->upload_image->file_name) {
                if ($crousel->upload_image) {
                    $crousel->upload_image->delete();
                }
                $crousel->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
            }
        } elseif ($crousel->upload_image) {
            $crousel->upload_image->delete();
        }

        return (new CrouselResource($crousel))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Crousel $crousel)
    {
        abort_if(Gate::denies('crousel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crousel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
