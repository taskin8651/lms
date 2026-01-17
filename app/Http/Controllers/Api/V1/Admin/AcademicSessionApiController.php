<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAcademicSessionRequest;
use App\Http\Requests\UpdateAcademicSessionRequest;
use App\Http\Resources\Admin\AcademicSessionResource;
use App\Models\AcademicSession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcademicSessionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('academic_session_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AcademicSessionResource(AcademicSession::all());
    }

    public function store(StoreAcademicSessionRequest $request)
    {
        $academicSession = AcademicSession::create($request->all());

        return (new AcademicSessionResource($academicSession))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AcademicSession $academicSession)
    {
        abort_if(Gate::denies('academic_session_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AcademicSessionResource($academicSession);
    }

    public function update(UpdateAcademicSessionRequest $request, AcademicSession $academicSession)
    {
        $academicSession->update($request->all());

        return (new AcademicSessionResource($academicSession))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AcademicSession $academicSession)
    {
        abort_if(Gate::denies('academic_session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $academicSession->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
