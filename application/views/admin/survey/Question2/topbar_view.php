<?php 
    $languages = $oSurvey->allLanguages;

    $permissions = [];
    $buttons = [];

    // TODO: Translation Methode finden, die nur den Wert zurückgibt und keinen Output macht!

    $hasReadPermission = Permission::model()->hasSurveyPermission($surveyid, 'surveycontent', 'read');
    if ($hasReadPermission) {
        $readPermission = ['read', $hasReadPermission];
        array_push($permissions, $readPermission);

        // Check Logic Button
        $buttons['check_logic'] = [];
        foreach($languages as $language) {
            $array = [
                $language => [
                    'url' => $this->createUrl("admin/expressions/sa/survey_logic_file/sid/{$surveyid}/gid/{$gid}/"),
                    'name' => eT("Check logic"),
                ],
            ];
            array_push($buttons['check_logic'], $array);
        }
    }
    
    $hasDeletePermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','delete' );
    if ($hasDeletePermission) {
        $deletePermission = ['delete', $hasDeletePermission];
        array_push($permissions, $deletePermission);

        // Delete Button 
        $buttons['delete'] = [
            'url' => $this->createUrl("admin/questions/sa/delete/", ["surveyid" => $surveyid, "qid" => $qid, "gid" => $gid]),
            'name' => eT("Delete")
        ];

        array_push($buttons, $buttons['delete']);
    }

    $hasExportPermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','export');
    if ($hasExportPermission) {
        $exportPermission = ['export', $hasExportPermission];
        array_push($permissions, $exportPermission);

        $buttons['export'] = [
            'url' => $this->createUrl("admin/export/sa/question/surveyid/$surveyid/gid/$gid/qid/$qid"),
            'name'=> eT("Export")
        ];

        array_push($buttons, $buttons['export']);
    }

    $hasCopyPermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','create');
    if ($hasCopyPermission) {
        $copyPermission = ['copy', $hasCopyPermission];
        array_push($permissions, $copyPermission);

        // Button Copy
        $buttons['copy'] = [
            'url'  => $this->createUrl("admin/questions/sa/copyquestion/surveyid/$surveyid/gid/$gid/qid/$qid"),
            'name' => eT("Copy")
        ];

        array_push($buttons, $buttons['copy']);
    }

    $hasUpdatePermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','update');
    if ($hasUpdatePermission) {
        $updatePermission = ['update', $hasUpdatePermission];
        array_push($permissions, $updatePermission);

        // Conditions Button 
        $buttons['conditions'] = [
            'url'  => $this->createUrl("admin/conditions/sa/index/subaction/editconditionsform/surveyid/$surveyid/gid/$gid/qid/$qid"),
            'name' => eT("Set conditions")
        ];
        array_push($buttons, $buttons['conditions']);

        // qtypes wird global gesetzt
        if($qtypes[$qrrow['type']]['hasdefaultvalues'] > 0) {
            $buttons['default_values'] = [
                'url' => $this->createUrl("admin/questions/sa/editdefaultvalues/suveyid/".$surveyid."/gid/".$gid."/qid/".$qid),
                'name' => eT("Edit default anwers")
            ];

            array_push($buttons, $buttons['default_values']);
        }
    }

    $permissionsJSON = json_encode($permissions);
    $data['langs'] = [];

    // Preview/Execute Button 
    foreach($languages as $language) {
        $array = [
            'url' => $this->createUrl("survey/index", array(
                'sid'     => $surveyid,
                'newtest' => "Y",
                'lang'    => $language)),
            'name' => getLanguageNameFromCode($language, false),
        ];

        array_push($data['langs'], $array);
    }

?>

<div id="vue-topbar-container">
    <topbar permissions='<?php echo $permissionsJSON ?>'></topbar>
</div>
