<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreClassLevelRequest;
use App\Http\Requests\UpdateClassLevelRequest;
use App\Http\Resources\Admin\ClassLevelResource;
use App\Models\ClassLevel;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClassLevelApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('class_level_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ClassLevelResource(ClassLevel::all());
    }

    public function store(StoreClassLevelRequest $request)
    {
        $classLevel = ClassLevel::create($request->all());

        return (new ClassLevelResource($classLevel))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ClassLevel $classLevel)
    {
        abort_if(Gate::denies('class_level_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ClassLevelResource($classLevel);
    }

    public function update(UpdateClassLevelRequest $request, ClassLevel $classLevel)
    {
        $classLevel->update($request->all());

        return (new ClassLevelResource($classLevel))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ClassLevel $classLevel)
    {
        abort_if(Gate::denies('class_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classLevel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
