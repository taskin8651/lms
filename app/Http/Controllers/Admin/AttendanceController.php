<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyAttendanceRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Attendance;
use App\Models\BatchStudent;
use App\Models\Teacher;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class AttendanceController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendances = Attendance::with(['batch_student', 'marked_by', 'media'])->get();

        return view('admin.attendances.index', compact('attendances'));
    }

    public function create()
    {
        abort_if(Gate::denies('attendance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batch_students = BatchStudent::pluck('joining_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $marked_bies = Teacher::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.attendances.create', compact('batch_students', 'marked_bies'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        $attendance = Attendance::create($request->all());

        if ($request->input('punch_in_image', false)) {
            $attendance->addMedia(storage_path('tmp/uploads/' . basename($request->input('punch_in_image'))))->toMediaCollection('punch_in_image');
        }

        if ($request->input('punch_out_image', false)) {
            $attendance->addMedia(storage_path('tmp/uploads/' . basename($request->input('punch_out_image'))))->toMediaCollection('punch_out_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $attendance->id]);
        }

        return redirect()->route('admin.attendances.index');
    }

    public function edit(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batch_students = BatchStudent::pluck('joining_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $marked_bies = Teacher::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        $attendance->load('batch_student', 'marked_by');

        return view('admin.attendances.edit', compact('attendance', 'batch_students', 'marked_bies'));
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->all());

        if ($request->input('punch_in_image', false)) {
            if (! $attendance->punch_in_image || $request->input('punch_in_image') !== $attendance->punch_in_image->file_name) {
                if ($attendance->punch_in_image) {
                    $attendance->punch_in_image->delete();
                }
                $attendance->addMedia(storage_path('tmp/uploads/' . basename($request->input('punch_in_image'))))->toMediaCollection('punch_in_image');
            }
        } elseif ($attendance->punch_in_image) {
            $attendance->punch_in_image->delete();
        }

        if ($request->input('punch_out_image', false)) {
            if (! $attendance->punch_out_image || $request->input('punch_out_image') !== $attendance->punch_out_image->file_name) {
                if ($attendance->punch_out_image) {
                    $attendance->punch_out_image->delete();
                }
                $attendance->addMedia(storage_path('tmp/uploads/' . basename($request->input('punch_out_image'))))->toMediaCollection('punch_out_image');
            }
        } elseif ($attendance->punch_out_image) {
            $attendance->punch_out_image->delete();
        }

        return redirect()->route('admin.attendances.index');
    }

    public function show(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendance->load('batch_student', 'marked_by');

        return view('admin.attendances.show', compact('attendance'));
    }

    public function destroy(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendance->delete();

        return back();
    }

    public function massDestroy(MassDestroyAttendanceRequest $request)
    {
        $attendances = Attendance::find(request('ids'));

        foreach ($attendances as $attendance) {
            $attendance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('attendance_create') && Gate::denies('attendance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Attendance();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
