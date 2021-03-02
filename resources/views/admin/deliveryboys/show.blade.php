@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.deliveryboy.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deliveryboys.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryboy.fields.id') }}
                        </th>
                        <td>
                            {{ $deliveryboy->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryboy.fields.first_name') }}
                        </th>
                        <td>
                            {{ $deliveryboy->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryboy.fields.last_name') }}
                        </th>
                        <td>
                            {{ $deliveryboy->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryboy.fields.email') }}
                        </th>
                        <td>
                            {{ $deliveryboy->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryboy.fields.email_verified_at') }}
                        </th>
                        <td>
                            {{ $deliveryboy->email_verified_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryboy.fields.roles') }}
                        </th>
                        <td>
                            @foreach($deliveryboy->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deliveryboy.fields.regions') }}
                        </th>
                        <td>
                            @foreach($deliveryboy->regions as $key => $regions)
                                <span class="label label-info">{{ $regions->region_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.deliveryboys.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection