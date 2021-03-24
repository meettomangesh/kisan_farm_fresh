<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserCommunicationMessages;

class UserCommunicationMessagesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('communication_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$users = User::all();
        // $users = User::whereHas(
        //     'roles', function($q){
        //         //$q->whereNot('title', 'Delivery Boy');
        //         $q->whereNotIn('title', ['Delivery Boy','Customer']);
        //     }
        // )->get();
        $userCommunicationMessages = UserCommunicationMessages::all();
        // print_r($userCommunicationMessages); exit;
        return view('admin.communications.index', compact('userCommunicationMessages'));
    }

    public function create()
    {
        abort_if(Gate::denies('communication_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$roles = Role::all()->pluck('title', 'id');
        $roles = Role::all()->whereNotIn('title', ['Delivery Boy', 'Customer'])->pluck('title', 'id');


        return view('admin.communications.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.communications.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('communication_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->whereNotIn('title', ['Delivery Boy', 'Customer'])->pluck('title', 'id');

        $user->load('roles');

        return view('admin.communications.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.communications.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('communication_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('admin.communicationsshow', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('communication_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
