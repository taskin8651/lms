<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyContactDetailRequest;
use App\Http\Requests\StoreContactDetailRequest;
use App\Http\Requests\UpdateContactDetailRequest;
use App\Models\ContactDetail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactDetailController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('contact_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactDetails = ContactDetail::all();

        return view('admin.contactDetails.index', compact('contactDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('contact_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactDetails.create');
    }

    public function store(StoreContactDetailRequest $request)
    {
        $contactDetail = ContactDetail::create($request->all());

        return redirect()->route('admin.contact-details.index');
    }

    public function edit(ContactDetail $contactDetail)
    {
        abort_if(Gate::denies('contact_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactDetails.edit', compact('contactDetail'));
    }

    public function update(UpdateContactDetailRequest $request, ContactDetail $contactDetail)
    {
        $contactDetail->update($request->all());

        return redirect()->route('admin.contact-details.index');
    }

    public function show(ContactDetail $contactDetail)
    {
        abort_if(Gate::denies('contact_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contactDetails.show', compact('contactDetail'));
    }

    public function destroy(ContactDetail $contactDetail)
    {
        abort_if(Gate::denies('contact_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contactDetail->delete();

        return back();
    }

    public function massDestroy(MassDestroyContactDetailRequest $request)
    {
        $contactDetails = ContactDetail::find(request('ids'));

        foreach ($contactDetails as $contactDetail) {
            $contactDetail->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
