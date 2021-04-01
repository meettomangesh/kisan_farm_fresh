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
use App\Helper\EmailHelper;

class UserCommunicationMessagesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('communication_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $result = EmailHelper::send(array(
        //     'subject' => "Get well soon subject",
        //     'message' => '<table style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#000000;line-height:22px;width:600px" cellspacing="0" cellpadding="0" align="center">
        //     <tbody>
        //         <tr>
        //             <td style="border-top:3px solid #a1c13a;height:3px" valign="top" align="center">&nbsp;</td>
        //         </tr>
        //         <tr>
        //             <td style="padding: 10px 0;" align="center" valign="middle" width="90">
        //                 <a href="http://www.Frendzi.com" target="_blank">
        //                     <img class="CToWUd" src="http://13.234.133.94/admin/assets/images/brand-logo.png" alt="Frendzi" height="80" />
        //                 </a>
        //             </td>
        //         </tr>
        //         <tr>
        //             <td style="border-bottom:1px solid #ececec;height:1px" valign="top" align="center">&nbsp;</td>
        //         </tr>
        //         <tr>
        //             <td style="background-color:#f6f6f6" valign="top" align="center">
        //                 <table style="width:94%" cellspacing="12" cellpadding="0">
        //                     <tbody>
        //                         <tr>
        //                             <td style="font-size:14px;color:#454545;font-weight:bold" valign="middle" height="30" align="left">Dear Admin,</td>
        //                         </tr>
        //                         <tr>
        //                             <td style="font-size:14px;color:#454545;line-height:24px;padding-bottom:10px" valign="top" align="left">Refund needs to process for    Here are the details :</td>
        //                         </tr>
        //                         <tr>
        //                             <td style="font-size:14px;color:#454545;line-height:24px;padding-bottom:10px" valign="top" align="left">
        //                                 <label>
        //                                     <span>Sponsor Name:</span> 
                                        
        //                                 </lable>
        //                                 <br>
        //                                     <label>
        //                                         <span>Sponsor Code:</span> 
                                            
        //                                     </lable>
        //                                     <br>
        //                                         <label>
        //                                             <span>Amount:</span> 
                                                    
        //                                         </lable>
        //                                         <br>
        //                                             <label>
        //                                                 <span>Bank Name:</span> 
                                                        
        //                                             </lable>
        //                                             <br>
        //                                                 <label>
        //                                                     <span>Account Number:</span> 
                                                        
        //                                                 </lable>
        //                                                 <br>
        //                                                     <label>
        //                                                         <span>Swift Code:</span> 
                                                        
        //                                                     </lable>
        //                                                 </td>
        //                                             </tr>
        //                                             <tr>
        //                                                 <td style="font-size:14px;color:#454545;line-height:24px;padding-bottom:10px" valign="top" align="left">
        //                 Regards,
                                                        
        //                                                     <br>
        //                                                         <span style="color:#8cb53f;text-transform:uppercase;font-weight:bold">Team Frendzi</span>
        //                                                     </td>
        //                                                 </tr>
        //                                                 <tr>
        //                                                     <td style="font-size:3px;color:#454545;line-height:4px;" valign="top" align="left">
        //                                                         <hr>
        //                                                         </td>
        //                                                     </tr>
        //                                                     <tr>
        //                                                         <td style="font-size:11px;color:#454545;line-height:16px;padding-bottom:10px" valign="top" align="left">P.S. We also love hearing from you and helping you with any issues you have. Please reply to this email if you want to ask a question or just say hi.</td>
        //                                                     </tr>
        //                                                 </tbody>
        //                                             </table>
        //                                         </td>
        //                                     </tr>
        //                                     <tr>
        //                                         <td style="background-color:#8cb53f;padding:20px 0;text-transform:uppercase;font-weight:bold" valign="top" align="center">
        //                                             <strong style="color:#3c4d1b">Terms & conditions  | Privacy Policy  | Help</strong>
        //                                         </td>
        //                                     </tr>
        //                                 </tbody>
        //                             </table>',
        //     'to' => array(array('email' => 'meettomangesh@gmail.com'), array('email' => 'aky.nagare003@gmail.com')),
        //     'attachment' => array(
        //         array('attachment' => 'images/logo.png'),
        //         array('attachment' => 'images/sample.pdf')
        //     )
        // ));
        // echo 'email is sent' . $result;
        // exit;
        $userCommunicationMessages = UserCommunicationMessages::all();
        // print_r($userCommunicationMessages); exit;
        return view('admin.communications.index', compact('userCommunicationMessages'));
    }

    public function create()
    {
        abort_if(Gate::denies('communication_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $loyaltyTierIdsNames = [];
        $merchantListData = [];
        $deepLinkScreeningData = [];
        $deepLinkScreeningDataGolbal = [];
        $deepLinkScreeningDataGolbalList = [];
        //$roles = Role::all()->pluck('title', 'id');
        $roles = Role::all()->whereNotIn('title', ['Delivery Boy', 'Customer'])->pluck('title', 'id');


        return view('admin.communications.create', compact('roles', 'loyaltyTierIdsNames', 'merchantListData', 'deepLinkScreeningData', 'deepLinkScreeningDataGolbal', 'deepLinkScreeningDataGolbalList'));
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
