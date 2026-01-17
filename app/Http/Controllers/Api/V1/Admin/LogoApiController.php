<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreLogoRequest;
use App\Http\Requests\UpdateLogoRequest;
use App\Http\Resources\Admin\LogoResource;
use App\Models\Logo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('logo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LogoResource(Logo::all());
    }

    public function store(StoreLogoRequest $request)
    {
        $logo = Logo::create($request->all());

        if ($request->input('image_1', false)) {
            $logo->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_1'))))->toMediaCollection('image_1');
        }

        return (new LogoResource($logo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Logo $logo)
    {
        abort_if(Gate::denies('logo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LogoResource($logo);
    }

    public function update(UpdateLogoRequest $request, Logo $logo)
    {
        $logo->update($request->all());

        if ($request->input('image_1', false)) {
            if (! $logo->image_1 || $request->input('image_1') !== $logo->image_1->file_name) {
                if ($logo->image_1) {
                    $logo->image_1->delete();
                }
                $logo->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_1'))))->toMediaCollection('image_1');
            }
        } elseif ($logo->image_1) {
            $logo->image_1->delete();
        }

        return (new LogoResource($logo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Logo $logo)
    {
        abort_if(Gate::denies('logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
