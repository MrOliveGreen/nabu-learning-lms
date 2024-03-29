<?php

namespace App\Http\Controllers;

use App\Models\ConfigModel;
use App\Models\InterfaceCfgModel;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\JsonDecoder;
use App\Models\LanguageModel;
use App\Models\TranslateModel;
use App\Models\SiteSettingModel;
use App\Models\TemplateModel;
use App\Models\ReportsModel;
use App\Models\ReportTemplateModel;
use App\Models\ReportImages;
use App\Models\CompanyModel;
use App\Models\GroupModel;
use App\Models\LessonsModel;
use App\Models\LessonCourses;
use App\Models\MailHistories;
use App\Models\MailTemplateModel;
use App\Models\PositionModel;
use App\Models\MailImages;
use App\Models\SessionModel;
use App\Models\TrainingsModel;

use DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $doublelogin = SiteSettingModel::where("name", "doublelogin")->first()->value;
        $clientsListArray = User::get_clientsInfo();
        $clientsList = array();
        foreach ($clientsListArray as $key => $client) {
            $test = $client->toArray();
            $clientsList[$client->id] = array();

            foreach ($test as $key1 => $value) {
                $clientsList[$client->id][$key1] = $value;
            }
            $clientsList[$client->id]['interface_color'] = json_decode($clientsList[$client->id]["interface_color"]);
            $clientsList[$client->id]['email'] = json_decode($clientsList[$client->id]["contact_info"])->email;
            $clientsList[$client->id]['contact_info'] = json_decode($clientsList[$client->id]["contact_info"])->address;
            $clientsList[$client->id]['pptimport'] = $clientsList[$client->id]["config"];
            $clientsList[$client->id]['config'] = "";
        }
        $languages=LanguageModel::all();
        $q = count($request->all())!=0?$request->input("search"):null;
        if(empty($q)){
            $translates = TranslateModel::select('tb_translations.*', 'tb_languages.language_iso as lang_iso')
            ->leftjoin('tb_languages', 'tb_languages.language_id', '=', 'tb_translations.language_id')
            ->paginate(8);
        } else {
            $translates = TranslateModel::select('tb_translations.*', 'tb_languages.language_iso as lang_iso')
            ->leftjoin('tb_languages', 'tb_languages.language_id', '=', 'tb_translations.language_id');
            if($q!="undefined"){
                $translates = $translates->where('translation_value', 'LIKE', '%' . $q . '%')
                ->orWhere('translation_string', 'LIKE', '%' . $q . '%');
            }
            $data=$translates
            ->offset($request->input("page")?$request->input("page")*8:0)
            ->limit(8)
            ->get()
            ->toArray();
            $links = $translates
            ->paginate(8);
            return response()->json(["result"=>$data, 'link'=>$links]);
        }
        // print_r(json_decode($clientsList[$client->id]["pptimport"])->PPTImport); exit;
        // print_r($clientsList[$client->id]['interface_color']);
        // exit;
        // print_r($clientsList['6665']['interface_color']);
        // $a = json_decode($clientsList['6667']['interface_color']);
        // print_r($clientsList);
        // exit;
        // dd($translates);exit;

        return view('clients.layout', compact('clientsList', 'languages', 'translates', 'doublelogin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return view('student.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
            'company' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'contact_info' => 'required',
            'email' => 'required',
            'lang' => 'required',
            'pack' => 'required'
        ]);
        
        $interfaceCfg = InterfaceCfgModel::create([
            'interface_color' => $request->input('interface_color'),
            'interface_icon' => $request->input('base64_img_data'),
            'admin_id' => '1'
        ]);
        
        $config = ConfigModel::create([
            "id"=>$interfaceCfg->id,
            "config"=>$request->input('pptimport')
        ]);
        
        $contact_info = array(
            "address" => $request->input('contact_info'),
            "email" => $request->input('email')
        );
        
        $client = User::create([
            'login' => $request->input('login'),
            'password' => base64_encode($request->input('password')),
            'company' => $request->input('company'),
            'first_name' => $request->input('firstname'),
            'last_name' => $request->input('lastname'),
            'contact_info' => json_encode($contact_info),
            'lang' => $request->input('lang'),
            'pack' => $request->input('pack'),
            'id_config' => $interfaceCfg->id,
            'type' => 1,
            'id_creator' => 1
        ]);

        $defaultTemplate = TemplateModel::where("default_user", 1)->first();
        $new_defaultTemplate = $defaultTemplate->replicate();
        $new_defaultTemplate->default_user = $client->id;
        $new_defaultTemplate->id_creator = $client->id;
        $new_defaultTemplate->save();
        // var_dump($client->id);
        // exit;
        
        // return response()->json(['success'=>'Client has been added']);
        return redirect("/clients")->with("success", 'Client has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'login' => 'required',
            'company' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'contact_info' => 'required',
            'email' => 'required',
            'lang' => 'required',
            'pack' => 'required'
        ]);
        
        $contact_info = array(
            'address' => $request->input('contact_info'),
            'email' => $request->input('email')
        );
        
        $client = User::find($id);
        
        $interfaceCfg = InterfaceCfgModel::find($client->id_config);
        $interfaceCfg->interface_color = $request->input('interface_color');
        $interfaceCfg->interface_icon = $request->input('base64_img_data');
            
        $interfaceCfg->update();
        
        $config = ConfigModel::find($client->id_config);
        if($config!=null) {
            if(isset($config->config))
            $config->config = $request->input('pptimport');
            $config->update();
        }
        // var_dump($tempconfig);exit;

        $client->login = $request->input('login');
        $client->company = $request->input('company');
        if ($request->input('password')!=null) {
            $client->password = base64_encode($request->input('password'));
        }
        $client->first_name = $request->input('firstname');
        $client->last_name = $request->input('lastname');
        $client->status = $request->input('status');
        $client->contact_info = json_encode($contact_info);
        $client->lang = $request->input('lang');
        $client->pack = $request->input('pack');

        $client->update();

        // return response()->json(['success'=>'Client updated successfully']);
        return redirect("/clients")->with("success", 'client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // print_r("dflsjldf"); exit();
        // print_r($client);exit;
        // var_dump($client->id);
        // exit;
        $client = User::find($id);

        $sessions = SessionModel::get();
        foreach($sessions as $session){
            if(DB::connection('mysql_historic')->getSchemaBuilder()->hasTable("tb_evaluation_{$session->id}")){
                $evals = DB::connection('mysql_historic')->select("SELECT id FROM `tb_evaluation_{$session->id}` WHERE user_id={$id}");
                DB::connection('mysql_historic')->delete("DELETE FROM `tb_evaluation_{$session->id}` WHERE user_id={$id}");
                if(DB::connection('mysql_historic')->getSchemaBuilder()->hasTable("tb_evaluation_question_{$session->id}")){
                    foreach($evals as $eval){
                        DB::connection('mysql_historic')->delete("DELETE FROM `tb_evaluation_question_{$session->id}` WHERE id_evaluation={$eval->id}");
                    }
                }
            }
            if(DB::connection('mysql_historic')->getSchemaBuilder()->hasTable("tb_screen_stats_{$session->id}"))
                DB::connection('mysql_historic')->delete("DELETE FROM `tb_screen_stats_{$session->id}` WHERE user_id={$id}");
            if(DB::connection('mysql_reports')->getSchemaBuilder()->hasTable("tb_screen_optim_{$session->id}"))
                DB::connection('mysql_reports')->delete("DELETE FROM `tb_screen_optim_{$session->id}` WHERE id_user_screen_optim={$id}");
        }

        InterfaceCfgModel::where('id', $client->id_config)->delete();
        ConfigModel::where('id', $client->id_config)->delete();
        // User::drop_admin_table($id);

        // Delete Reports
        $reports = ReportsModel::where('id_creator', $id)->orWhere('studentId', $id)->get();
        foreach($reports as $report){
            if($report->filename && file_exists(storage_path('pdf') . '/' . $filename))
                unlink(file_exists(storage_path('pdf') . '/' . $filename));
        }
        ReportsModel::where('id_creator', $id)->delete();
        ReportTemplateModel::where('id_creator', $id)->delete();
        ReportImages::where('userId', $id)->delete();

        // Delete Companies
        CompanyModel::where('id_creator', $id)->delete();

        // Delete Groups
        GroupModel::where('id_creator', $id)->delete();

        // Delete Lessons
        $lessons = LessonsModel::where('idCreator', $id)->get();
        foreach($lessons as $lesson){
            LessonCourses::where('curso_id', $lesson->id)->delete();
        }
        LessonsModel::where('idCreator', $id)->delete();

        // Delete Mail Histories
        $histories = MailHistories::where('id_creator', $id)->orWhere('senderId', $id)->get();
        foreach($histories as $history){
            if(file_exists(storage_path('pdf') . "/mail_result_${$history->id}.pdf"))
                unlink(storage_path('pdf') . "/mail_result_${$history->id}.pdf");
        }
        MailTemplateModel::where('id_creator', $id)->delete();
        MailImages::where('userId', $id)->delete();

        // Delete Positions
        PositionModel::where('id_creator', $id)->delete();

        // Delete Sessions
        SessionModel::where('id_creator', $id)->delete();

        // Delete Templates
        $templates = TemplateModel::where('id_creator', $id)->get();
        foreach($templates as $template){
            DB::table('tb_template_html5')->where('alpha_id', $template->alpha_id)->delete();
            $template->delete();
        }

        // Delete Trainings
        TrainingsModel::where('id_creator', $id)->delete();

        // Delete users
        User::where('id_creator', $id)->delete();

        $client->delete();
        return response('Deleted Successfully', 200);
    }

    // public function searchTranslate(Request $request) {
    //     $q = $request->post("search");
    //     $page = $request->post("page");
    //     $translates = TranslateModel::select('tb_translations.*', 'tb_languages.language_iso as lang_iso')
    //     ->leftjoin('tb_languages', 'tb_languages.language_id', '=', 'tb_translations.language_id')
    //     ->where('translation_value', 'LIKE', '%' . $q . '%')
    //     ->orWhere('translation_string', 'LIKE', '%' . $q . '%')
    //     ->paginate(8);
    //     return response()->json(["result"=>$translates->appends(['search' => $q])]);
    // }
}
