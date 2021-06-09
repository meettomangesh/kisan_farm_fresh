<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDeliveryBoyRequest;
use App\Http\Requests\StoreDeliveryBoyRequest;
use App\Http\Requests\UpdateDeliveryBoyRequest;
use App\Role;
use App\DeliveryBoy;
use App\User;
use App\Models\UserDetails;
use App\Region;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\EmailHelper;
use App\Helper\DataHelper;

class DeliveryBoysController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deliveryboy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryboys = User::whereHas(
            'roles',
            function ($q) {
                $q->where('title', 'Delivery Boy');
            }
        )->get();

        $regions = Region::all()->where('status', 1)->pluck('region_name', 'id');

        return view('admin.deliveryboys.index', compact('deliveryboys', 'regions'));
    }

    public function create()
    {
        abort_if(Gate::denies('deliveryboy_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->where('title', 'Delivery Boy')->pluck('title', 'id');
        $regions = Region::all()->where('status', 1)->pluck('region_name', 'id');

        return view('admin.deliveryboys.create', compact('roles', 'regions'));
    }

    public function store(StoreDeliveryBoyRequest $request)
    {
        //print_r($request->all());exit;
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));
        $user->regions()->sync($request->input('regions', []));
        $emailVerifyUrl = config('services.miscellaneous.EMAIL_VERIFY_URL');
        if (!empty($request->email)) {
            $request['email_verify_key'] = DataHelper::emailVerifyKey();
        }
        if (!empty($request->email)) {
            EmailHelper::sendEmail(
                'IN_APP_EMAIL_VERIFICATION',
                [
                    'link' => $emailVerifyUrl . 'verify?key=' . $request['email_verify_key'],
                    'email_to' => $request->email, //$request->email_address
                    'customerName' => $user->first_name . " " . $user->last_name,
                    'isEmailVerified' => 1
                ],
                [
                    'attachment' => []
                ]
            );
        }

        return redirect()->route('admin.deliveryboys.index');
    }

    public function edit(User $deliveryboy)
    {
        abort_if(Gate::denies('deliveryboy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->where('title', 'Delivery Boy')->pluck('title', 'id');
        $regions = Region::all()->where('status', 1)->pluck('region_name', 'id');

        $deliveryboy->load('roles');
        $deliveryboy->load('regions');

        return view('admin.deliveryboys.edit', compact('roles', 'deliveryboy', 'regions'));
    }

    public function update(UpdateDeliveryBoyRequest $request, User $deliveryboy)
    {

        $deliveryboy->update($request->all());
        $deliveryboy->roles()->sync($request->input('roles', []));
        $deliveryboy->regions()->sync($request->input('regions', []));
        return redirect()->route('admin.deliveryboys.index');
    }

    public function show(User $deliveryboy)
    {
        abort_if(Gate::denies('deliveryboy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryboy->load('roles');
        $deliveryboy->load('regions');
        $deliveryboy->load('details');
        return view('admin.deliveryboys.show', compact('deliveryboy'));
    }

    public function destroy(User $deliveryboy)
    {
        abort_if(Gate::denies('deliveryboy_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryboy->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeliveryBoyRequest $request)
    {
        DeliveryBoy::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function changeKYCStatus(Request $request)
    {
        $user = UserDetails::find($request->user_id)->update(['status' => $request->status]);

        return response()->json(['success' => 'Status changed successfully.']);
    }
}
