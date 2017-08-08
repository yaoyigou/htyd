<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => 'required|max:60|unique:users',
            //'email' => 'required|email|max:255|unique:users',
            'password'  => 'required|confirmed|min:6|max:24',
            'msn'       => 'required|min:4|unique:users',
            'province'  => 'required|exists:region,region_id',
            'city'      => 'required|exists:region,region_id',
            'district'  => 'required|exists:region,region_id',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'user_name'    => $data['user_name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'user_rank'    => $data['ls_lx'],
            'ls_name'      => $data['ls_name'],
            'msn'          => $data['msn'],
            'qq'           => $data['qq'],
            'mobile_phone' => $data['mobile_phone'],
            'country'      => 1,
            'province'     => $data['province'],
            'city'         => $data['city'],
            'district'     => $data['district'],
            'reg_time'     => time(),
            'last_login'   => time(),
            'last_ip'      => '',
            'visit_count'  => 1,
            'update_time'  => time(),
        ]);
    }

    public function reg_check(Request $request)
    {
        $id  = $request->input('id');
        $act = $request->input('act');
        if ($act == 'select_area') {
            $address     = get_region_list($id);
            $regionshtml = "";
            foreach ($address as $k => $v) {
                $regionshtml .= "<li data-id={$k}>{$v}</li>";
            }
            return $regionshtml;
        }
        if ($act == 'is_name') {
            $user_id = User::where('user_name', $id)->value('user_id');
            $type    = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_msn') {
            $user_id = User::where('msn', $id)->value('user_id');
            $type    = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_qq') {
            return 1;
            $user_id = User::where('qq', $id)->value('user_id');
            $type    = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_email') {
            return 1;
            $user_id = User::where('email', $id)->value('user_id');
            $type    = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_tel') {
            return 1;
            $user_id = User::where('mobile_phone', $id)->orwhere('home_phone', $id)->value('user_id');
            $type    = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_email') {
            $user_id = User::where('email', $id)->value('user_id');
            $type    = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
    }
}
