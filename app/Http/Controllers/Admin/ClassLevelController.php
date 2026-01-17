<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyClassLevelRequest;
use App\Http\Requests\StoreClassLevelRequest;
use App\Http\Requests\UpdateClassLevelRequest;
use App\Models\ClassLevel;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ClassLevelController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('class_level_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classLevels = ClassLevel::all();

        return view('admin.classLevels.index', compact('classLevels'));
    }

    public function create()
    {
        abort_if(Gate::denies('class_level_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.classLevels.create');
    }

    public function store(StoreClassLevelRequest $request)
    {
        $classLevel = ClassLevel::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $classLevel->id]);
        }

        return redirect()->route('admin.class-levels.index');
    }

    public function edit(ClassLevel $classLevel)
    {
        abort_if(Gate::denies('class_level_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.classLevels.edit', compact('classLevel'));
    }

    public function update(UpdateClassLevelRequest $request, ClassLevel $classLevel)
    {
        $classLevel->update($request->all());

        return redirect()->route('admin.class-levels.index');
    }

    public function show(ClassLevel $classLevel)
    {
        abort_if(Gate::denies('class_level_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.classLevels.show', compact('classLevel'));
    }

    public function destroy(ClassLevel $classLevel)
    {
        abort_if(Gate::denies('class_level_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classLevel->delete();

        return back();
    }

    public function massDestroy(MassDestroyClassLevelRequest $request)
    {
        $classLevels = ClassLevel::find(request('ids'));

        foreach ($classLevels as $classLevel) {
            $classLevel->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('class_level_create') && Gate::denies('class_level_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ClassLevel();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
