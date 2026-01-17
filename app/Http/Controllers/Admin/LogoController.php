<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyLogoRequest;
use App\Http\Requests\StoreLogoRequest;
use App\Http\Requests\UpdateLogoRequest;
use App\Models\Logo;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class LogoController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('logo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logos = Logo::with(['media'])->get();

        return view('admin.logos.index', compact('logos'));
    }

    public function create()
    {
        abort_if(Gate::denies('logo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.logos.create');
    }

    public function store(StoreLogoRequest $request)
    {
        $logo = Logo::create($request->all());

        if ($request->input('image_1', false)) {
            $logo->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_1'))))->toMediaCollection('image_1');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $logo->id]);
        }

        return redirect()->route('admin.logos.index');
    }

    public function edit(Logo $logo)
    {
        abort_if(Gate::denies('logo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.logos.edit', compact('logo'));
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

        return redirect()->route('admin.logos.index');
    }

    public function show(Logo $logo)
    {
        abort_if(Gate::denies('logo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.logos.show', compact('logo'));
    }

    public function destroy(Logo $logo)
    {
        abort_if(Gate::denies('logo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $logo->delete();

        return back();
    }

    public function massDestroy(MassDestroyLogoRequest $request)
    {
        $logos = Logo::find(request('ids'));

        foreach ($logos as $logo) {
            $logo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('logo_create') && Gate::denies('logo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Logo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
