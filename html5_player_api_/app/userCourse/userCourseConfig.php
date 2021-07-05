<?php
    session_start();
    /* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $formationId
    -  @Input $productId;
    -  @Input $courseId;
    -  @Input $userId;
    -  $return || Variable de retour du Json
    -
    -
    ----------------------------------------------------------------------- */

    $return             = array();
    $return['state']    = 'success';
    $return['date']     = date( 'm.d.y H:i:s' );
    $return['msg']      = 'Config du cours';
    $return['datas']    = array();

    /* ----------------------------------------------------------------------
    - REQUETE
    -
    -
    ----------------------------------------------------------------------- */

    if ( !$_SESSION['user_id'] )
    {
        $return['state']    = 'error';
        $return['date']     = date( 'm.d.y H:i:s' );
        $return['msg']      = 'Votre session a expirée ou vous ne vous êtes pas identifié - veuillez vous reconnecter';
        $return['datas']    = array();
    } // eo if
    else
    {
        include( dirname( __FILE__ ) . '/../../config/config.php' );
        include( dirname( __FILE__ ) . '/../../dbModel.php' );

        class openModel extends dbModel
        {
            public function __construct()
            {
                parent::__construct();
            } // eo constructor
        } // eo openModel class

        $openModel  = new openModel;


        /**
         * GET all the variables from DATA BASE
         */

        // Load the configs datas from database
        $sql_config         = "SELECT * FROM tb_config WHERE id = " . $_SESSION['config_id'];

        // echo $sql_config;
        $results            = $openModel->getDatas( $sql_config );
        $config_datas       = $results[0];

        // Get the "automaticLaunch" value of config.xml file and put it in a variable - this parameter able the player to launch the next lesson automatically without going back to the student context
        $automaticLaunch    = $config_datas['AutoOpenNextLesson'] ? "true":"false";

        // Get the value of enableEvaluation to enable ou disable the acess to the evaluation
        $enableEvaluation   = $config_datas['enableEvaluation'] ? "true":"false";

        /**
         * GET VARIABLES FROM DATA BASE
         */

        $sql        = "SELECT threshold_score,template_player_id FROM `tb_lesson` WHERE idFabrica = '$productId'";
        $results    = $openModel->getDatas( $sql );

        // Threshold Score of the Lesson
        $thresholdscore = $results[0]['threshold_score'];

        /**
         * Get nextLessons
         */

        $next           = false;
        $where          = '';
        $nextlesson     = '';
        $nextlessons    = array();
        $alllessons     = array();

        if( $_SESSION['user_status'] == 4 )
        {
            $where  = " AND c.status = 7 ";
        } // eo if

        // $sql        = "SELECT c.idFabrica FROM tb_lesson c LEFT JOIN tb_manage_formations_courses mfc ON mfc.id_course = c.id WHERE mfc.id_formation = '$formationId' $where ORDER BY mfc.order";
        // $results    = $openModel->getDatas( $sql );

        // foreach( $results as $row )
        // {
        //     if ( $next )
        //     {
        //         // We are ahead from curretn course
        //         if ( count( $nextlessons ) == 0 )
        //         {
        //             // Here is the next course
        //             $nextlesson = $row['idFabrica'];
        //         } // eo if

        //         // Populate nextLessons
        //         $nextlessons[]  = $row['idFabrica'];
        //     } // eo if

        //     if ( $row['idFabrica'] == $productId )
        //     {
        //         // We are on the current course
        //         $next  = true;
        //     } // eo if

        //     // Populate allLessons
        //     $alllessons[]   = $row['idFabrica'];
        // } // eo foreach


        if ( !$_SESSION['user_id'] )
        {
            $return['state']    = 'error';
            $return['date']     = date( 'm.d.y H:i:s' );
            $return['msg']      = 'Aucunes données trouvées';
            $return['datas']    = array();
        } // eo if
        else
        {
            $return['datas']['productId']           = $productId;
            $return['datas']['courseId']            = $courseId;
            $return['datas']['userId']              = $user_id;
            $return['datas']['automaticLaunch']     = $automaticLaunch;
            $return['datas']['enableEvaluation']    = $enableEvaluation;
            $return['datas']['nextLesson']          = $nextlesson;
            $return['datas']['nextLessons']         = $nextlessons;
            $return['datas']['allLessons']          = $alllessons;
            $return['datas']['thresholdscore']      = $thresholdscore;

            if($nextlesson != ''){
                $sql = "SELECT lang, profile FROM tb_users WHERE id = " . $_SESSION['user_id'];
                $userdata = $openModel->getDatas( $sql );
                if($userdata[0])
                {
                    $sql = "SELECT language_iso FROM tb_languages WHERE language_id = " . $userdata[0]['lang'];
                    $lang = $openModel->getDatas( $sql );
                    if($lang[0])
                    {
                        $sql = "SELECT * FROM tb_lesson_courses WHERE product_id = '" . $nextlesson . "' AND profile = '" . $userdata[0]['profile'] . "' AND lang = '" . $lang[0]['language_iso'] . "'";
                        $lessondata = $openModel->getDatas( $sql );
                        if($lessondata[0])
                            $return['datas']['nextCourseId'] = $lessondata[0]['course_id'];
                        else{
                            $sql = "SELECT * FROM tb_lesson_courses WHERE product_id = '" . $nextlesson . "' AND profile = '0' AND lang = '" . $lang[0]['language_iso'] . "'";
                            $lessondata = $openModel->getDatas( $sql );
                            if($lessondata[0])
                                $return['datas']['nextCourseId'] = $lessondata[0]['course_id'];
                        }
                    }
                }
            }
        } // eo else
    } // eo else

    header( 'Content-type: application/json' );
    echo json_encode( $return );
    die();
