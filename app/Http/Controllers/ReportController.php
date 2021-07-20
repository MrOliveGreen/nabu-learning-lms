<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ReportsModel;
use App\Models\ReportTemplateModel;
use App\Models\ReportImages;
use App\Models\SessionModel;
use App\Models\TrainingsModel;
use App\Models\LessonCourses;
use App\Models\LanguageModel;

use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = ReportTemplateModel::get();
        $images = ReportImages::where('userId', Auth::user()->id)->get();
        $sessions = SessionModel::getSessionPageInfo();
        return view('report.view')->with('templates', $templates)->with('images', $images)->with('sessions', $sessions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        //
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
        //
    }

    /**
     * Return server-side rendered table list.
     *
     * @param  Request  $request
     * @return JSON
     */
    public function getReportList(Request $request){
        $columns = array( 
            0 =>'session', 
            1 =>'filename',
            2 =>'type',
            3 =>'detail',
            4 =>'created_time'
        );
        $totalData = ReportsModel::count();
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $handler = new ReportsModel;
        $handler = $handler->leftjoin('tb_session', "tb_session.id", "=", "tb_reports.sessionId");

        if(empty($request->input('search.value')))
        {            
            $totalFiltered = $handler->count();
            $reports = $handler->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get(
                    array(
                        'tb_reports.id as id',
                        'tb_session.description as session',
                        'tb_reports.filename as filename',
                        'tb_reports.type as type',
                        'tb_reports.detail as detail',
                        'tb_reports.created_time as created_time',
                    )
                );
        }
        else {
            $search = $request->input('search.value'); 
            $reports =  $handler->where(function ($q) use ($search) {
                            $q->where('tb_reports.id','LIKE',"%{$search}%")
                            ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.type', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.detail', 'LIKE',"%{$search}%")
                            ->orWhere('tb_reports.created_time', 'LIKE',"%{$search}%");
                        })
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get(
                            array(
                                'tb_reports.id as id',
                                'tb_session.description as session',
                                'tb_reports.filename as filename',
                                'tb_reports.type as type',
                                'tb_reports.detail as detail',
                                'tb_reports.created_time as created_time',
                            )
                        );

            $totalFiltered = $handler->where(function ($q) use ($search) {
                                $q->where('tb_reports.id','LIKE',"%{$search}%")
                                ->orWhere('tb_reports.filename', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.type', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.detail', 'LIKE',"%{$search}%")
                                ->orWhere('tb_reports.created_time', 'LIKE',"%{$search}%");
                            })
                        ->count();
        }

        $data = array();

        if(!empty($reports))
        {
            foreach ($reports as $report)
            {
                $nestedData['id'] = $report->id;
                $nestedData['session'] = $report->session;
                $nestedData['filename'] = $report->filename;
                $nestedData['type'] = $report->type;
                $nestedData['detail'] = $report->detail;
                $nestedData['created_time'] = $report->created_time;
                
                $nestedData['actions'] = "
                <div class='text-center'>
                    <button type='button' class='js-swal-confirm btn btn-danger' onclick='delCompany(this,{$nestedData['id']})'>
                        <i class='fa fa-trash'></i>
                    </button>
                </div>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );
        echo json_encode($json_data);
    }

    /**
     * Return model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getTemplateData(Request $request){
        if(!empty($request['id'])){
            $template = ReportTemplateModel::where('id', $request['id'])->first();
            if($template)
                return response()->json(["success" => true, "data" => $template->data, "name" => $template->name]);
            else
                return response()->json(["success" => false, "message" => "Cannot find template."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Save model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function saveTemplateData(Request $request){
        if(!empty($request['id']) && !empty($request['name'])){
            $template = ReportTemplateModel::where('id', $request['id'])->first();
            if($template){
                $template->name = $request['name'];
                $template->data = $request['data'];
                $template->save();
                return response()->json(["success" => true]);
            }
            else{
                $template = ReportTemplateModel::create([
                    'name' => $request['name'],
                    'data' => $request['data'],
                    'created_time' => gmdate("Y-m-d\TH:i:s", time())
                ]);
                return response()->json(["success" => true, "id" => $template->id]);
            }
        } else
            return response()->json(["success" => false, "message" => "Missing id or name."]);
    }

    /**
     * Delete model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function delTemplate(Request $request){
        if(!empty($request['id'])){
            $template = ReportTemplateModel::where('id', $request['id'])->first();
            if($template){
                $template->delete();
                return response()->json(["success" => true]);
            }
            else
                return response()->json(["success" => false, "message" => "Cannot find template."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Delete model template data.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getBlockHTML(Request $request){
        if(!empty($request['name'])){
            return response()->json(["success" => true, "html" => view('report.' . $request['name'])->render()]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Save base64 image to db.
     *
     * @param  Request  $request
     * @return JSON
     */
    function saveReportImg(Request $request){
        if(!empty($request['data'])){
            ReportImages::create([
                'userId' => Auth::user()->id,
                'data' => $request['data']
            ]);
            return response()->json(["success" => true]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Retrieve students' list of the session.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getStudentsList(Request $request){
        if(!empty($request['sessionId'])){
            $session = SessionModel::find($request['sessionId']);
            if($session){
                $students = SessionModel::getStudentsFromSession($session->participants);
                return response()->json(["success" => true, "students" => $students]);
            } else
                return response()->json(["success" => false, "message" => "Cannot find the session."]);
        } else
            return response()->json(["success" => false, "message" => "Missing id."]);
    }

    /**
     * Retrieve report data for a student of a session.
     *
     * @param  Request  $request
     * @return JSON
     */
    function getReportData(Request $request){
        if(!empty($request['sessionId']) && !empty($request['studentId'])){
            $data = array();
            $user = User::find($request['studentId']);
            if($user){
                $data['student'] = $user;
            } else
                response()->json(["success" => false, "message" => "Cannot find the student."]);

            $language_iso = LanguageModel::get_language_iso($user['lang']);
            if($language_iso == '')
                $language_iso = LanguageModel::get_language_iso(1);
            
            $session = SessionModel::find($request['sessionId']);
            if($session){
                $trainingIds = explode("_", $session->contents);
                $data['trainings'] = array();
                foreach($trainingIds as $trainingId){
                    $training = TrainingsModel::find($trainingId);
                    $lessons = [];
                    if($training){
                        if ($training->lesson_content) {
                            $lessonList = json_decode($training->lesson_content, true);
                            if ($lessonList != NULL) {
                                foreach ($lessonList as $value) {
                                    if (LessonsModel::find($value['item'])) {
                                        if (!in_array(LessonsModel::getLessonContainedTraining($value['item']), $lessons)) {
                                            array_push($lessons, LessonsModel::getLessonContainedTraining($value['item']));
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $lessonData = [];
                    foreach($lessons as $lesson){
                        $lessonInfo = array("lesson" => $lesson);
                        $lessonCourse = LessonCourses::getLessonCourse($lesson['id'], $language_iso);
                        $lessonInfo["lessonCourse"] = $lessonCourse;
                        
                        $module_structure = json_decode($lessonCourse->module_structure);
                        $lessonInfo["screensCount"] = $this->helperCountScreensModule($module_structure);
                        $lessonInfo["chaptersCount"] = $this->helperCountChaptersModule($module_structure);
                        
                        //$lessonInfo["optim"] = 

                        $lessonData[] = $lessonInfo;
                    }

                    $data['trainings'][] = array("training" => $training, "lessons" => $lessonData);
                }
                return response()->json(["success" => true, "data" => $data]);
            } else
                response()->json(["success" => false, "message" => "Cannot find the session."]);
        } else
            return response()->json(["success" => false, "message" => "Empty parameters."]);
    }

    /**
     * Return count of screens from module structure.
     *
     * @param  Array  $module_structure
     * @return Integer
     */
    private function helperCountScreensModule($module_structure) {
        $nb_screens = 0;
        if (!empty($module_structure)) {
            foreach ($module_structure as $screen) {
                // On vire du total les screen nav = FALSE
                if (isset($screen->nav) && $screen->nav != "false") {
                    $nb_screens++;
                }
            }
        }
        return $nb_screens;
    }

    /**
     * Return count of chapters from module structure.
     *
     * @param  Array  $module_structure
     * @return Integer
     */
    private function helperCountChaptersModule($module_structure) {
        $nb_chapters = 0;
        if (!empty($module_structure)) {
            foreach ($module_structure as $screen) {
                // On vire du total les screen nav = FALSE
                if (!isset($screen->nav) || $screen->nav == "false") {
                    $nb_chapters++;
                }
            }
        }
        return $nb_chapters;
    }
}
