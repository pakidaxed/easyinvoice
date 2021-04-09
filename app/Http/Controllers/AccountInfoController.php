<?php

namespace App\Http\Controllers;

use App\Models\AccountInfo;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:2|max:25',
            'last_name' => 'required|min:2|max:25',
            'phone' => 'digits_between:1,20',
            'code' => 'required|digits_between:1,20',
            'vat_code' => 'max:20',
            'personal_id' => 'digits_between:1,15',
            'address' => 'required|max:150',
            'post_code' => 'max:8',
            'city' => 'required|integer',
            'bank' => 'required|integer',
            'bank_account_number' => 'required|max:30',
            'prefix' => 'required|min:1|max:3|alpha',
            'logo' => 'image|max:2048'

        ]);

        $accountInfo = AccountInfo::where('user_id', Auth::id())->firstOrNew();

        $accountInfo->user_id = Auth::id();
        $accountInfo->first_name = $request->input('first_name');
        $accountInfo->last_name = $request->input('last_name');
        $accountInfo->phone = $request->input('phone');
        $accountInfo->code = $request->input('code');
        $accountInfo->vat_code = $request->input('vat_code');
        $accountInfo->personal_id = $request->input('personal_id');
        $accountInfo->address = $request->input('address');
        $accountInfo->post_code = $request->input('post_code');
        $accountInfo->city_id = $request->input('city');
        $accountInfo->bank_id = $request->input('bank');
        $accountInfo->bank_account_number = $request->input('bank_account_number');
        $accountInfo->prefix = $request->input('prefix');

        $request->file('logo')->store('public/images/logos');
        $accountInfo->logo = $request->file('logo')->hashName();
        $accountInfo->save();

        return redirect(route('account.edit'))->with('success', 'Data updated successfully');
    }
}
