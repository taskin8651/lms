<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Resources\Admin\AttendanceResource;
use App\Models\Attendance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendanceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('attendance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendanceResource(Attendance::with(['batch_student', 'marked_by'])->get());
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

        return (new AttendanceResource($attendance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AttendanceResource($attendance->load(['batch_student', 'marked_by']));
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

        return (new AttendanceResource($attendance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Attendance $attendance)
    {
        abort_if(Gate::denies('attendance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $attendance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
