<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Session\Session;
use App\Http\core\Language;
use App\Models\LanguageModel;
use App\Models\InterfaceCfgModel;
use Illuminate\Support\Facades\DB;
use App\Models\SiteSettingModel;

use Auth;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;
use App\Http\Controllers\PermissionController;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "dash";

    protected $PermissionController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PermissionController $permissionController)
    {
        $this->middleware('guest')->except('logout');
        $this->PermissionController = $permissionController;
    }

    protected function attemptLogin(Request $request)
    {

        // $tables = DB::select('SHOW TABLES');
        // foreach($tables as $table)
        // {
        //     if(str_contains(array_values((array)$table)[0], "tb_admin_")){
        //         $tableName = array_values((array)$table)[0];
        //     echo $table->Tables_in_db_name;
        //     print_r("<br>");
        //     }
        // }
        // exit;

        $user = User::where('email', $request->email)
            ->where('password', base64_encode($request->password))
            ->first();

        // var_dump($user->password);die;

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($fieldType, '=', $request->input['username'])->first();

        if ($user) {
            auth()->loginUsingId($user->id);
            return $this->sendLoginResponse($request);
            //return redirect()->route('home');
        } else {
            $validator->errors()->add('username', 'These credentials do not match our records.');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        if (!isset($user)) {
            return false;
        }

        Auth::login($user);

        return true;
    }


    protected function login(Request $request)
    {

        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        // $tables = DB::select('SHOW TABLES');
        // $result = array();
        // foreach($tables as $table)
        // {
        //     if(str_contains(array_values((array)$table)[0], "tb_admin_")){
        //         $tableName = array_values((array)$table)[0];
        //         $result = DB::table($tableName)->where('login', '=', $input['username'])->orWhere('contact_info', 'like', "%" . $input['username'] . "%")->get();
        //         foreach ($result as $user) {
        //             if (Hash::check($input['password'], $user->password)) {
        
        //                 $request->session()->regenerate();
        //                 // var_dump(session()->getID());die;
        //                 auth()->login($user);
        //                 dd(auth()->user());
        //                 exit;
        
        //                 DB::table($tableName)->where('id', '=', $user->id)->update(['last_session'=> session()->getID()]);
        //                 session_start();
        //                 $request->session()->put('user_id', auth()->user()->id);
        //                 $request->session()->put('user_name', auth()->user()->login);
        //                 $_SESSION['config_id'] = auth()->user()->id_config;
        //                 session(['slider-control' => true]);
        //                 return $this->sendLoginResponse($request);
        //             }
        //         }
        //     }
        // }

        // $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        $result = User::where('login', '=', $input['username'])->orWhere('contact_info', 'like', "%" . $input['username'] . "%")->get();

        $dbLoginSetting = SiteSettingModel::where("name", "doublelogin")->first("value");
        foreach ($result as $user) {
            if (base64_encode($input['password']) == $user->password) {
                if(!empty($user->last_session) && $dbLoginSetting->value==1) {
                    $validator->errors()->add('username', 'Unable to log in. You are already loged in another location');
                    return redirect()->route('login')->withErrors($validator)->withInput();
                }
                $request->session()->regenerate();
                // var_dump(session()->getID());die;
                auth()->loginUsingId($user->id, true);

                $user->last_session = session()->getID();

                $user->save();
                session_start();
                $request->session()->put('user_id', auth()->user()->id);
                $request->session()->put('user_name', auth()->user()->login);
                $_SESSION['config_id'] = auth()->user()->id_config;
                //                 session(['user_id' => auth()->user()->id]);
                //minimized sliderbar
                session(['slider-control' => true]);
                return $this->sendLoginResponse($request);
            }
        }


        $validator->errors()->add('username', 'These credentials do not match our records.');
        return redirect()->route('login')->withErrors($validator)->withInput();
    }

    protected function logout()
    {
        $user = User::find(auth()->user()->id);
        $user->last_session = "";
        $user->update();

        Auth::logout();
        session()->flush();
        return redirect('login');
    }

    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

    protected function sendLoginResponse(Request $request)
    {
        
        $this->clearLoginAttempts($request);
        session(["user_type"=>auth()->user()->type]);
        if (auth()->user()->type == 0 || auth()->user()->type == 1) {
            $this->redirectTo = 'admindash';
            if(auth()->user()->type == 1) {
                if(auth()->user()->id_config){
                    $interface = InterfaceCfgModel::find(auth()->user()->id_config);
                    if($interface->interface_color!=null) {
                        $interfaceColorList = json_decode($interface->interface_color);
                        if($interfaceColorList->menuBackground != null) {
                            session(["menuBackground" => $interfaceColorList->menuBackground]);
                        }
                        if($interfaceColorList->pageBackground != null) {
                            session(["pageBackground" => $interfaceColorList->pageBackground]);
                        }
                        if($interfaceColorList->iconOverColor != null) {
                            session(["iconOverColor" => $interfaceColorList->iconOverColor]);
                        }
                        if($interfaceColorList->iconDefaultColor != null) {
                            session(["iconDefaultColor" => $interfaceColorList->iconDefaultColor]);
                        }
                    }
                }
                session(["client" => auth()->user()->id]);
            } else {
                $client = User::getClients();
                if(count($client)!=0 && $client!=null){
                    session(["client" => $client[0]["id"]]);
                }
            }
        } else if(auth()->user()->type == 3) {
            $this->redirectTo = "student";
            session(["client" => auth()->user()->id_creator]);
        } else if(auth()->user()->type == 2) {
            $this->redirectTo = "training";

        } else {

            $this->redirectTo = 'dash';
        }
        session(['language' => 'en']);
        $this->PermissionController->setPermission();


        if ($this->guard()->user()!=NULL) {
            return redirect()->intended($this->redirectPath());

        } else {
            echo "False";
        }

        // return $this->authenticated($request, $this->guard()->user())
        //     ?: redirect()->intended($this->redirectPath());
    }

    
}
