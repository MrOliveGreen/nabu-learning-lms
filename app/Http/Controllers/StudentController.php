<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use App\Models\InterfaceCfgModel;
use App\Models\User;
use App\Models\GroupModel;
use App\Models\PositionModel;
use App\Models\CompanyModel;
use App\Models\ConfigModel;
use App\Models\SessionModel;

use Hackzilla\PasswordGenerator\Generator\RequirementPasswordGenerator;



class StudentController extends Controller
{
    public function index()
    {
        $students = User::getUserPageInfo(4);
        $authors = User::getUserPageInfo(2);
        $teachers = User::getUserPageInfo(3);
        $groups = GroupModel::all();
        $positions = PositionModel::all();
        $companies = CompanyModel::all();

        return view('student', compact(['authors', 'teachers', 'students', 'groups', 'positions', 'companies']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $generator = new RequirementPasswordGenerator();



        $password = $generator->generatePassword();
        $generator
            ->setLength(6)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_UPPER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_LOWER_CASE, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_NUMBERS, true)
            ->setOptionValue(RequirementPasswordGenerator::OPTION_SYMBOLS, true)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_UPPER_CASE, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_LOWER_CASE, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_NUMBERS, 1)
            ->setMinimumCount(RequirementPasswordGenerator::OPTION_SYMBOLS, 1);
        return response()->json([
            'name' => 'New User',
            'password' => $password
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $interfaceCfg = InterfaceCfgModel::create([
            'interface_color' => '',
            'interface_icon' => $request->post('base64_img_data'),
            'admin_id' => '1'
        ]);

        $contact_info = array(
            "address" => $request->post('contact_info'),
            'email' => $request->post('user-email')
        );
        if (null !== $request->post('position')) {
            $position = $request->post('position');
        }

        $client = User::create([
            'login' => $request->post('login'),
            'password' => $request->post('password'),
            'first_name' => $request->post('first_name'),
            'last_name' => $request->post('last_name'),
            'contact_info' => json_encode($contact_info),
            'id_config' => $interfaceCfg->id,
            'status' => $request->input('user-status-icon'),
            'type' => $request->post('type'),
            'expired_date'=>$request->post('expired_date')
            // 'lang' => $request->post('lang'),
        ]);

        if ($request->post('company') != null) {
            $client->company = $request->post('company');
        }
        if ($request->post('function') != null) {
            $client->function = $request->post('function');
        }
        if ($request->post('password') != null) {
            $client->password = $request->post('password');
        }
        $client->update();
        return response()->json($client);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_info = User::getUserPageInfoFromId($id);
        $session = SessionModel::select('session_name')->where('user_id',  $id)->get();

        return response()->json(['user_info' => $user_info, 'session' => $session]);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_info = User::getUserPageInfoFromId($id);
        $session = SessionModel::select('session_name')->where('user_id',  $id)->get();

        return response()->json(['user_info' => $user_info, 'session' => $session]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);
        $interface_cfg = null;
        if ($user->id_config == null || $user->id_config == '0') {
            $interface_cfg = InterfaceCfgModel::create([
                "interface_icon" => $request->input("base64_img_data"),
                'admin_id' => 1,
                'interface_color' => ''
            ]);
            if (InterfaceCfgModel::find($user->id_config) == null) {
                ConfigModel::create([
                    "id" => $interface_cfg->id,
                    "config" => ''
                ]);
            }
        } else if (InterfaceCfgModel::find($user->id_config) == null) {
            InterfaceCfgModel::create([
                'id' => $user->id_config,
                "interface_icon" => $request->input("base64_img_data"),
                'admin_id' => 1,
                'interface_color' => ''
            ]);
        } else {
            $interface_cfg = InterfaceCfgModel::find($user->id_config);
            $interface_cfg->interface_icon = $request->input("base64_img_data");
            $interface_cfg->update();
        }
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->login = $request->input('login');
        if (null !== $request->post('position')) {
            $user->function = $request->input('function');
        }
        if ($request->post('company')) {
            $user->company = $request->post('company');
        }
        $user->status = $request->input('user-status-icon');
        if ($request->input('password') != null) {
            $user->password = $request->input('password');
        }
        if ($user->contact_info != null) {
            $address = json_decode($user->contact_info);
            $address->address = $request->input('contact_info');
            $address->email = $request->input('user-email');
            $user->contact_info = json_encode($address);
        } else {
            $contact_info = array(
                "address" => $request->input('contact_info'),
                "email" => $request->input('user-email')
            );
            $user->contact_info = json_encode($contact_info);
        }
        $user->expired_date=$request->post('expired_date');

        $user->update();

        return response()->json($user);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return response('successfully deleted!', 200);
        //
    }

    public function userJoinToGroup(Request $request)
    {
        // foreach ($variable as $key => $value) {
        //     # code...
        // }
        // foreach ($request->post("data") as $key => $value) {
        //     print_r(json_decode($value->id));
        //     print_r(json_decode($value->));
        // }
        // print_r();
        $responseData = [];
        $data = json_decode($request->post('data'));
        if (count($data) != 0) {
            foreach ($data as $value) {
                $user = User::find($value->id);

                $user->linked_groups = $value->target;

                $user->update();

                array_push($responseData, $user);
            }
        }
        return response()->json($responseData);
    }

    public function userJoinToCompany(Request $request)
    {
        $data = json_decode($request->post('data'));
        if (count($data) != 0) {
            foreach ($data as $key => $value) {
                $user = User::find($value->id);

                $user->company = $value->target;

                $user->update();
            }
        }

        return response()->json($user);
    }

    public function userJoinToPosition(Request $request)
    {
        $data = json_decode($request->post('data'));
        if (count($data) != 0) {
            foreach ($data as $key => $value) {
                $user = User::find($value->id);

                $user->function = $value->target;

                $user->update();
            }
        }

        return response()->json($user);
    }
}
