<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyStudyMaterialRequest;
use App\Http\Requests\StoreStudyMaterialRequest;
use App\Http\Requests\UpdateStudyMaterialRequest;
use App\Models\Chapter;
use App\Models\StudyMaterial;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class StudyMaterialController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('study_material_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studyMaterials = StudyMaterial::with(['chapter', 'media'])->get();

        return view('admin.studyMaterials.index', compact('studyMaterials'));
    }

    public function create()
    {
        abort_if(Gate::denies('study_material_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chapters = Chapter::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.studyMaterials.create', compact('chapters'));
    }

    public function store(StoreStudyMaterialRequest $request)
    {
        $studyMaterial = StudyMaterial::create($request->all());

        if ($request->input('file', false)) {
            $studyMaterial->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $studyMaterial->id]);
        }

        return redirect()->route('admin.study-materials.index');
    }

    public function edit(StudyMaterial $studyMaterial)
    {
        abort_if(Gate::denies('study_material_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chapters = Chapter::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studyMaterial->load('chapter');

        return view('admin.studyMaterials.edit', compact('chapters', 'studyMaterial'));
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

        return redirect()->route('admin.study-materials.index');
    }

    public function show(StudyMaterial $studyMaterial)
    {
        abort_if(Gate::denies('study_material_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studyMaterial->load('chapter');

        return view('admin.studyMaterials.show', compact('studyMaterial'));
    }

    public function destroy(StudyMaterial $studyMaterial)
    {
        abort_if(Gate::denies('study_material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studyMaterial->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudyMaterialRequest $request)
    {
        $studyMaterials = StudyMaterial::find(request('ids'));

        foreach ($studyMaterials as $studyMaterial) {
            $studyMaterial->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('study_material_create') && Gate::denies('study_material_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new StudyMaterial();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
