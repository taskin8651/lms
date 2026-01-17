<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBatchStudentRequest;
use App\Http\Requests\UpdateBatchStudentRequest;
use App\Http\Resources\Admin\BatchStudentResource;
use App\Models\BatchStudent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BatchStudentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('batch_student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BatchStudentResource(BatchStudent::with(['batch', 'student'])->get());
    }

    public function store(StoreBatchStudentRequest $request)
    {
        $batchStudent = BatchStudent::create($request->all());

        return (new BatchStudentResource($batchStudent))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BatchStudent $batchStudent)
    {
        abort_if(Gate::denies('batch_student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BatchStudentResource($batchStudent->load(['batch', 'student']));
    }

    public function update(UpdateBatchStudentRequest $request, BatchStudent $batchStudent)
    {
        $batchStudent->update($request->all());

        return (new BatchStudentResource($batchStudent))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BatchStudent $batchStudent)
    {
        abort_if(Gate::denies('batch_student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batchStudent->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
