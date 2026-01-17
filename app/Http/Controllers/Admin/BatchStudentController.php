<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBatchStudentRequest;
use App\Http\Requests\StoreBatchStudentRequest;
use App\Http\Requests\UpdateBatchStudentRequest;
use App\Models\Batch;
use App\Models\BatchStudent;
use App\Models\Student;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BatchStudentController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('batch_student_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batchStudents = BatchStudent::with(['batch', 'student'])->get();

        return view('admin.batchStudents.index', compact('batchStudents'));
    }

    public function create()
    {
        abort_if(Gate::denies('batch_student_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.batchStudents.create', compact('batches', 'students'));
    }

    public function store(StoreBatchStudentRequest $request)
    {
        $batchStudent = BatchStudent::create($request->all());

        return redirect()->route('admin.batch-students.index');
    }

    public function edit(BatchStudent $batchStudent)
    {
        abort_if(Gate::denies('batch_student_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batches = Batch::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $students = Student::pluck('mobile', 'id')->prepend(trans('global.pleaseSelect'), '');

        $batchStudent->load('batch', 'student');

        return view('admin.batchStudents.edit', compact('batchStudent', 'batches', 'students'));
    }

    public function update(UpdateBatchStudentRequest $request, BatchStudent $batchStudent)
    {
        $batchStudent->update($request->all());

        return redirect()->route('admin.batch-students.index');
    }

    public function show(BatchStudent $batchStudent)
    {
        abort_if(Gate::denies('batch_student_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batchStudent->load('batch', 'student');

        return view('admin.batchStudents.show', compact('batchStudent'));
    }

    public function destroy(BatchStudent $batchStudent)
    {
        abort_if(Gate::denies('batch_student_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $batchStudent->delete();

        return back();
    }

    public function massDestroy(MassDestroyBatchStudentRequest $request)
    {
        $batchStudents = BatchStudent::find(request('ids'));

        foreach ($batchStudents as $batchStudent) {
            $batchStudent->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
