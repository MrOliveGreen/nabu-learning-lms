<?php

require_once('inc/contentsCourse.class.php');
require_once('inc/courseProcessor.fnc.php');
require_once(__DIR__.'/../../config/config.php');
/* ----------------------------------------------------------------------
    - INITIALISATION DES VARIABLES
    -  @Input $productId;
    -  @Input $courseId;
    -  $refresh || Rafraichi le fichier Json si true
    -  $lang || Langue du fichier cours pris en compte pour la génération
    -  $chaptersList || Liste des ids des cours étant des chapitres
    -  $toKnowMoreList || Liste des ids des cours étant des chapitres
    -  $documentList || Liste des ids des cours étant des chapitres
    -  $return || Variable de retour du Json
    -  $pathDefault || path selon si fabrique ou online
    -
    -
    ----------------------------------------------------------------------- */

// Get JSON datas

$form_data  = json_decode(file_get_contents('php://input'));
$refresh = false;
if ($form_data->refresh) {
    $refresh = $form_data->refresh;
}
$preview = false;
if ($form_data->preview) {
    $preview = $form_data->preview;
}

// Initialisations des variables
$lang = null;
$chaptersList = array();
$toKnowMoreList = array();
$documentList = array();
$return = array();
$return['state'] = 'success';
$return['productId'] = $productId;
$return['dateCreate'] = date("m.d.y H:i");
$return['msg'] = 'Le cours ' . $productId . ' existe bien.';
$return['datas'] = array();
$return['datas']['label'] = null;
$return['datas']['lang'] = null;
$return['datas']['start'] = null;
$return['datas']['courses'] = null;

if ($preview == true) {
    $pathDefault = PRODUCTS_FABRIQUE_PATH;
    $urlDefault = PRODUCTS_FABRIQUE_URL;
} else {
    $pathDefault = FABRIQUE_PRODUCTS_PATH;
    $urlDefault = FABRIQUE_PRODUCTS_URL;
}

/* ----------------------------------------------------------------------
    - RECHERCHE DU FICHIER DU PRODUIT ET TYPE DE COURS CORRESPONDANT
    -
    -
    ----------------------------------------------------------------------- */
$tempDatas = array();
$tempDatas['pathFolder'] = $pathDefault;
$tempDatas['productId'] = $productId;
$tempDatas['courseId'] = $courseId;
$tempDatas['contentId'] = null;
$tempDatas['lang'] = null;

$fileUrl = fileUrl("courses", $tempDatas);
//    echo json_encode($fileUrl);
$fileUrl = str_replace("//", "/", $fileUrl);
$parentUrl = fileUrl("parent", $tempDatas);
$parentUrl = str_replace("//", "/", $parentUrl);
$tempDatas = null;
//echo json_encode($fileUrl);
//    echo json_encode($productId);
if ($fileUrl == null && $productId != "TEMPLATEGENERATOR") {
    $return['state'] = 'error';
    $return['msg'] = 'aaAucunes variables de cours';
    $return['datas'] = null;
    header('Content-Type: application/json');
    echo json_encode($return);
    die();
}
$jsonUrl = $pathDefault . $productId . '/' . $productId . '_' . $courseId . '.json';
$jsonUrl = str_replace("//", "/", $jsonUrl);
/* ----------------------------------------------------------------------
    - GENERATION DU FICHIER JSON
    -
    -
    ----------------------------------------------------------------------- */
if (!file_exists($jsonUrl) || $refresh == true) {
    $fullDatas = array();
    $xml = generateXml($fileUrl);

    $lang = (string)$xml->attributes()->lang;
    // CHAPTERS
    foreach ($xml->statistics->chapters->chapter as $chapter) {
        array_push($chaptersList, (string)$chapter->attributes()->id);
    }
    // TOKNOWMORE
    if ($xml->toknowmore) {
        foreach ($xml->toknowmore->item as $item) {
            $itemDatas = array();
            $itemDatas['id'] = (string)$item->attributes()->id; // ID
            $itemDatas['ref'] = null; // REFERENCE
            if ($item->attributes()->ref) {
                $itemDatas['ref'] = (string)$item->attributes()->ref;
            }
            $itemDatas['layout'] = null; // TEMPLATE
            if ($item->attributes()->layout) {
                $itemDatas['layout'] = (string)$item->attributes()->layout;
            }
            //$itemDatas['type'] = 'toKnowMore';
            $itemDatas['contents'] = null;
            $itemDatas['error'] = null;
            $tempDatas = array();
            $tempDatas['pathFolder'] = $pathDefault;
            $tempDatas['productId'] = $productId;
            $tempDatas['courseId'] = null;
            $tempDatas['contentId'] = $itemDatas['ref'];
            $tempDatas['lang'] = $lang;
            $fileUrl = fileUrl("content", $tempDatas);
            $tempDatas = null;
            if ($fileUrl == null) {
                $itemDatas['error'] = 'Le contenu de la page est inexistant (REF: ' . $itemDatas['ref'] . ' )';
            } else {
                $contentXml = generateXml($fileUrl, "content");
                $contentObj = array();
                //$contentObj->type = 'toKnowMore';
                $urlFile = FABRIQUE_PRODUCTS_URL . $productId . '/content/' . $itemDatas['ref'] . '/';
                $contentObj = new ContentsCourse($contentXml, $itemDatas['layout'], true, $lang, $urlFile);
                $itemDatas['contents'] = $contentObj->read();
                $itemDatas['type'] = $contentObj->readType();
            }
            array_push($toKnowMoreList, $itemDatas);
        }
    }
    // DOCUMENTS
    if ($xml->documents) {
        foreach ($xml->documents->document as $document) {
            $documentDatas = array();
            $documentDatas['id'] = (string)$document->attributes()->id; // ID
            $documentDatas['type'] = (string)$document->attributes()->type; // REFERENC
            $documentDatas['url'] = $urlDefault . $productId . '/documents/' . (string)$document->attributes()->name;
            array_push($documentList, $documentDatas);
        }
    }
    $courseName = "";
    $xmlParent = generateXml($parentUrl);
    if ($xmlParent->courses) {
        foreach ($xmlParent->courses->course as $c) {
            if ((string)$c->attributes()->lang === (string)$xml->attributes()->lang) {
                $courseName = (string)$c->attributes()->name;
            }
        }
    }

    foreach ($xml->group as $datas) {
        $config = array();
        $config['productId'] = $productId;
        $config['lang'] = $lang;
        $config['chaptersList'] = $chaptersList;
        $config['toKnowMoreList'] = $toKnowMoreList;
        $config['documentList'] = $documentList;
        $config['pathFolder'] = $pathDefault;
        $datasImport = array();
        $datasImport = processor($datas, $config);
        $datasImport['isChapter'] = true;
        array_push($fullDatas, $datasImport);
    }
    $return['state'] = 'success';
    $return['dateCreate'] = date("m.d.y H:i");
    $return['msg'] = 'Le cours ' . $productId . ' existe bien.';
    $return['datas'] = array();
    $return['datas']['label'] = (string)$xml->attributes()->label;
    $return['datas']['courseName'] = (string)$xml->attributes()->label;
    $return['datas']['lang'] = (string)$xml->attributes()->lang;
    $return['datas']['start'] = (string)$xml->attributes()->start;
    if ($xml->attributes()->background)
        $return['datas']['background'] = $urlDefault . $productId . '/content/' . (string)$xml->attributes()->background;
    if ($xml->attributes()->globalbackground)
        $return['datas']['globalbackground'] = $urlDefault . $productId . '/content/' . (string)$xml->attributes()->globalbackground;
    $return['datas']['courses'] = $fullDatas;

    include(dirname(__FILE__) . '/../../dbModel.php');

    class openModel extends dbModel
    {
        public function __construct()
        {
            parent::__construct();
        } // eo constructor
    } // eo openModel class

    $openModel  = new openModel;

    $curso_sql = 'select * from tb_lesson where idFabrica = "' . $productId . '"';
    $curso_result = $openModel->getDatas($curso_sql);
    $return['nome'] = $curso_result[0]['nome'];

    $fp = fopen($jsonUrl, 'w+');
    fwrite($fp, json_encode($return));
    fclose($fp);
}

/* ----------------------------------------------------------------------
    - LECTURE ET ENVOI DU FICHIER JSON
    -
    -
    ----------------------------------------------------------------------- */
if (file_exists($jsonUrl)) {
    $return = file_get_contents($jsonUrl);
    $return = json_decode($return);
    header('Content-type: application/json');
    echo json_encode($return);
    die();
} else {
    $return['state'] = 'error';
    $return['msg'] = 'Erreur durant la création du json';
    $return['datas'] = null;
    header('Content-Type: application/json');
    echo json_encode($return);
    die();
}
