<?php 
    $languages = $oSurvey->allLanguages;

    $permissions = [];
    $buttons = [];

    $hasReadPermission = Permission::model()->hasSurveyPermission($surveyid, 'surveycontent', 'read');
    if ($hasReadPermission) {
        $readPermission = ['read', $hasReadPermission];
        array_push($permissions, $readPermission);

        // Check Logic Button
        $buttons['check_logic'] = [];
        foreach($languages as $language) {
            $data = [
                'lang' => $language,
                'url' => $this->createUrl("admin/expressions/sa/survey_logic_file/sid/{$surveyid}/gid/{$gid}/"),
                'name' => gT("Check logic"),
            ];
            array_push($buttons['check_logic'], $data);
        }
    }
    
    $hasDeletePermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','delete' );
    if ($hasDeletePermission) {
        $deletePermission = ['delete', $hasDeletePermission];
        array_push($permissions, $deletePermission);

        // Delete Button 
        $buttons['delete'] = [
            'url' => $this->createUrl("admin/questions/sa/delete/", ["surveyid" => $surveyid, "qid" => $qid, "gid" => $gid]),
            'name' => gT("Delete")
        ];
    }

    $hasExportPermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','export');
    if ($hasExportPermission) {
        $exportPermission = ['export', $hasExportPermission];
        array_push($permissions, $exportPermission);

        $buttons['export'] = [
            'url' => $this->createUrl("admin/export/sa/question/surveyid/$surveyid/gid/$gid/qid/$qid"),
            'name'=> gT("Export")
        ];
    }

    $hasCopyPermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','create');
    if ($hasCopyPermission) {
        $copyPermission = ['copy', $hasCopyPermission];
        array_push($permissions, $copyPermission);

        // Button Copy
        $buttons['copy'] = [
            'url'  => $this->createUrl("admin/questions/sa/copyquestion/surveyid/$surveyid/gid/$gid/qid/$qid"),
            'name' => gT("Copy")
        ];
    }

    $hasUpdatePermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','update');
    if ($hasUpdatePermission) {
        $updatePermission = ['update', $hasUpdatePermission];
        array_push($permissions, $updatePermission);

        // Conditions Button 
        $buttons['conditions'] = [
            'url'  => $this->createUrl("admin/conditions/sa/index/subaction/editconditionsform/surveyid/$surveyid/gid/$gid/qid/$qid"),
            'name' => gT("Set conditions")
        ];

        // qtypes wird global gesetzt
        if($qtypes[$qrrow['type']]['hasdefaultvalues'] > 0) {
            $buttons['default_values'] = [
                'url' => $this->createUrl("admin/questions/sa/editdefaultvalues/suveyid/".$surveyid."/gid/".$gid."/qid/".$qid),
                'name' => gT("Edit default anwers")
            ];
        }
    }

    $permissionsJSON = json_encode($permissions);
    $buttonsJSON = json_encode($buttons);

?>

<div id="vue-topbar-container">
    <topbar permissions='<?php echo $permissionsJSON ?>'
            buttons='<?php echo $buttonsJSON ?>'>
    </topbar>
</div>
