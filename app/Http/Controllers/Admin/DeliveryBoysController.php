<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDeliveryBoyRequest;
use App\Http\Requests\StoreDeliveryBoyRequest;
use App\Http\Requests\UpdateDeliveryBoyRequest;
use App\Role;
use App\DeliveryBoy;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DeliveryBoysController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('deliveryboy_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryboys = User::whereHas(
            'roles', function($q){
                $q->where('title', 'Delivery Boy');
            }
        )->get();

        return view('admin.deliveryboys.index', compact('deliveryboys'));
    }

    public function create()
    {
        abort_if(Gate::denies('deliveryboy_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->where('title', 'Delivery Boy')->pluck('title', 'id');

        return view('admin.deliveryboys.create', compact('roles'));
    }

    public function store(StoreDeliveryBoyRequest $request)
    {
        $user = DeliveryBoy::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.deliveryboys.index');
    }

    public function edit(User $deliveryboy)
    {
        abort_if(Gate::denies('deliveryboy_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $deliveryboy->load('roles');

        return view('admin.deliveryboys.edit', compact('roles', 'deliveryboy'));
    }

    public function update(UpdateDeliveryBoyRequest $request, User $deliveryboy)
    {
        $deliveryboy->update($request->all());
        $deliveryboy->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.deliveryboys.index');
    }

    public function show(DeliveryBoy $deliveryboy)
    {
        abort_if(Gate::denies('deliveryboy_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deliveryboy->load('roles');

        return view('admin.deliveryboys.show', compact('deliveryboy'));
    }

    public function destroy(DeliveryBoy $deliveryboy)
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
}
