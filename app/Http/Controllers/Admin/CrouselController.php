<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCrouselRequest;
use App\Http\Requests\StoreCrouselRequest;
use App\Http\Requests\UpdateCrouselRequest;
use App\Models\Crousel;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CrouselController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('crousel_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crousels = Crousel::with(['media'])->get();

        return view('admin.crousels.index', compact('crousels'));
    }

    public function create()
    {
        abort_if(Gate::denies('crousel_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.crousels.create');
    }

    public function store(StoreCrouselRequest $request)
    {
        $crousel = Crousel::create($request->all());

        if ($request->input('upload_image', false)) {
            $crousel->addMedia(storage_path('tmp/uploads/' . basename($request->input('upload_image'))))->toMediaCollection('upload_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $crousel->id]);
        }

        return redirect()->route('admin.crousels.index');
    }

    public function edit(Crousel $crousel)
    {
        abort_if(Gate::denies('crousel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.crousels.edit', compact('crousel'));
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

        return redirect()->route('admin.crousels.index');
    }

    public function show(Crousel $crousel)
    {
        abort_if(Gate::denies('crousel_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.crousels.show', compact('crousel'));
    }

    public function destroy(Crousel $crousel)
    {
        abort_if(Gate::denies('crousel_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $crousel->delete();

        return back();
    }

    public function massDestroy(MassDestroyCrouselRequest $request)
    {
        $crousels = Crousel::find(request('ids'));

        foreach ($crousels as $crousel) {
            $crousel->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('crousel_create') && Gate::denies('crousel_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Crousel();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
