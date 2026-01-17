<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactDetailRequest;
use App\Http\Requests\UpdateContactDetailRequest;
use App\Http\Resources\Admin\ContactDetailResource;
use App\Models\ContactDetail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactDetailApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contact_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContactDetailResource(ContactDetail::all());
    }

    public function store(StoreContactDetailRequest $request)
    {
        $contactDetail = ContactDetail::create($request->all());

        return (new ContactDetailResource($contactDetail))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ContactDetail $contactDetail)
    {
        abort_if(Gate::denies('contact_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContactDetailResource($contactDetail);
    }

    public function update(UpdateContactDetailRequest $request, ContactDetail $contactDetail)
    {
        $contactDetail->update($request->all());

        return (new ContactDetailResource($contactDetail))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ContactDetail $contactDetail)
    {
        abort_if(Gate::denies('contact_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactDetail->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
