<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreStudyMaterialRequest;
use App\Http\Requests\UpdateStudyMaterialRequest;
use App\Http\Resources\Admin\StudyMaterialResource;
use App\Models\StudyMaterial;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudyMaterialApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('study_material_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudyMaterialResource(StudyMaterial::with(['chapter'])->get());
    }

    public function store(StoreStudyMaterialRequest $request)
    {
        $studyMaterial = StudyMaterial::create($request->all());

        if ($request->input('file', false)) {
            $studyMaterial->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new StudyMaterialResource($studyMaterial))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(StudyMaterial $studyMaterial)
    {
        abort_if(Gate::denies('study_material_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StudyMaterialResource($studyMaterial->load(['chapter']));
    }

    public function update(UpdateStudyMaterialRequest $request, StudyMaterial $studyMaterial)
    {
        $studyMaterial->update($request->all());

        if ($request->input('file', false)) {
            if (! $studyMaterial->file || $request->input('file') !== $studyMaterial->file->file_name) {
                if ($studyMaterial->file) {
                    $studyMaterial->file->delete();
                }
                $studyMaterial->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($studyMaterial->file) {
            $studyMaterial->file->delete();
        }

        return (new StudyMaterialResource($studyMaterial))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(StudyMaterial $studyMaterial)
    {
        abort_if(Gate::denies('study_material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studyMaterial->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
