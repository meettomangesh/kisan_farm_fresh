<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PromoCodeMaster;
use Gate;
use App\Role;
use App\User;
use App\Region;
use App\Models\CampaignCategoriesMaster;
use App\Models\CampaignMaster;
use DB;

class CampaignController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('campaign_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $campaigns = PromoCodeMaster::all();
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        abort_if(Gate::denies('campaign_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::all()->whereNotIn('title', ['Delivery Boy', 'Customer'])->pluck('title', 'id');
        $regions = Region::all()->where('status', 1)->pluck('region_name', 'id');
        $campaignCategoriesMaster = CampaignCategoriesMaster::all()->where('status', 1)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.campaigns.create', compact('campaigns', 'roles', 'regions', 'campaignCategoriesMaster'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $promoCodeMaster = PromoCodeMaster::addUpdateCampaignOffer($input);
        exit;
        return redirect()->route('admin.campaigns.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('campaign_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.campaigns.edit', compact('campaigns'));
    }

    public function update(Request $request, PromoCodeMaster $promoCodeMaster)
    {
        return redirect()->route('admin.campaigns.index');
    }

    public function getCampaignMaster($id)
    {
        $data['campaign_master'] = DB::table("campaign_master")->where("campaign_category_id", $id)->where("status", 1)->pluck("name", "id");
        $data['is_campaign_master_available'] = sizeof($data['campaign_master']);
        return json_encode($data);
    }

    public function getAllActiveCustomer()
    {
        $users = User::select(DB::raw('CONCAT(users.first_name, " ", users.last_name) AS name'), 'users.id')
            ->whereHas(
                'roles',
                function ($q) {
                    $q->where('title', 'Customer');
                    $q->where('status', 1);
                }
            )->get();
        $response['user_details'] = $users->pluck('name', 'id');

        $response['status'] = '';
        $response['message'] = '';

        return response()->json($response);
    }
}
