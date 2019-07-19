<?php
$languages   = $oSurvey->allLanguages;
$permissions = [];
$buttons     = [];
$topbar      = [
  'alignment' => [
    'left' => [
      'buttons' => []
    ],
  ],
];

$hasReadPermission = Permission::model()->hasSurveyPermission($sid, 'surveycontent', 'read');
if ($hasReadPermission) {
    $permissions['read'] = ['read' => $hasReadPermission];

    // Preview Survey / Execute Survey Button
    if ($oSurvey->active === 'N') {
        $title = 'preview_survey';
        $name  = gT('Preview survey');
    } else {
        $title = 'execute_survey';
        $name  = gT('Execute survey');
    }

    $buttons[$title] = [];

    foreach($languages as $language) {
        $buttons[$title] = [
            'url' => $this->createUrl("survey/index",
                        array('sid'     => $sid,
                              'newtest' => "Y",
                              'lang'    => $language)),
            'name' => $name,
            'icon' => 'fa fa-cog',
        ];
    }

    // Preview Question Group Button
    $buttons['preview_question_group'] = [];
    if(count($languages) > 1) {
        foreach($languages as $language) {
            $data= [
                'url'  => $this->createUrl("survey/index/action/previewgroup/sid/{$sid}/gid/{$gid}/lang/" . $language),
                'name' => gT("Preview question group"),
                'icon' => 'fa fa-cog',
            ];
        }
    } else {
        foreach($languages as $language) {
            $buttons['preview_question_group']= [
                'url'  => $this->createUrl("survey/index/action/previewgroup/sid/{$sid}/gid/{$gid}/lang/" . $language),
                'name' => gT("Preview question group"),
                'icon' => 'fa fa-cog',
            ];
        }
    }

    // Preview Question Button
    $buttons['preview_question'] = [];
    if (count($languages) > 1) {
        foreach($languages as $language) {
            $data = [
                'url' => $this->createUrl("survey/index/action/previewquestion/sid/" . $sid . "/gid/" . $gid . "/qid/" . $qid . "/lang/" . $language),
                'name' => gT("Preview question"),
                'icon' => 'fa fa-cog',
            ];
            array_push($buttons['preview_question'], $data);
        }
    } else {
        foreach($languages as $language) {
            $buttons['preview_question'] = [
                'url' => $this->createUrl("survey/index/action/previewquestion/sid/" . $sid . "/gid/" . $gid . "/qid/" . $qid . "/lang/" . $language),
                'name' => gT("Preview question"),
                'icon' => 'fa fa-cog',
            ];
        }
    }

    // Check Logic Button
    $buttons['check_logic'] = [];

    if(count($languages) > 1) {
        foreach($languages as $language) {
            $data = [
                'lang' => $language,
                'url' => $this->createUrl("admin/expressions/sa/survey_logic_file/sid/{$sid}/gid/{$gid}/"),
                'name' => gT("Check logic"),
            ];
            array_push($buttons['check_logic'], $data);
        }
    } else {
        $buttons['check_logic'] = [
            'url'  => $this->createUrl("admin/expressions/sa/survey_logic_file/sid/{$sid}/gid/{$gid}/"),
            'name' => gT("Check logic"),
            'icon' => 'icon-expressionmanagercheck'
        ];
    }

}

$hasDeletePermission = Permission::model()->hasSurveyPermission($sid,'surveycontent','delete' );
if ($hasDeletePermission) {
    $permissions['delete'] = ['delete' => $hasDeletePermission];

    // Delete Button
    $buttons['delete'] = [
        'url'  => $this->createUrl("admin/questions/sa/delete/", ["surveyid" => $sid, "qid" => $qid, "gid" => $gid]),
        'name' => gT("Delete"),
        'icon' => 'fa fa-trash text-danger'
    ];
}

$hasExportPermission = Permission::model()->hasSurveyPermission($sid,'surveycontent','export');
if ($hasExportPermission) {
    $permissions['export'] = ['export' => $hasExportPermission];

    // Export Button
    $buttons['export'] = [
        'url'  => $this->createUrl("admin/export/sa/question/surveyid/$sid/gid/$gid/qid/$qid"),
        'name' => gT("Export"),
        'icon' => 'icon-export',
    ];
}

$hasCopyPermission = Permission::model()->hasSurveyPermission($sid,'surveycontent','create');
if ($hasCopyPermission) {
    $permissions['copy'] = ['copy' => $hasCopyPermission];

    // Copy Button
    $buttons['copy'] = [
        'url'  => $this->createUrl("admin/questions/sa/copyquestion/surveyid/$sid/gid/$gid/qid/$qid"),
        'name' => gT("Copy"),
        'icon' => 'icon-copy',
    ];
}

$hasUpdatePermission = Permission::model()->hasSurveyPermission($sid,'surveycontent','update');
if ($hasUpdatePermission) {
    $permissions['update'] = ['update' => $hasUpdatePermission];

    // Conditions Button
    $buttons['conditions'] = [
        'url'  => $this->createUrl("admin/conditions/sa/index/subaction/editconditionsform/surveyid/$sid/gid/$gid/qid/$qid"),
        'name' => gT("Set conditions"),
        'icon' => 'icon-conditions',
    ];

    if($qtypes[$qrrow['type']]['hasdefaultvalues'] > 0) {
        $buttons['default_values'] = [
            'url'  => $this->createUrl("admin/questions/sa/editdefaultvalues/suveyid/".$sid."/gid/".$gid."/qid/".$qid),
            'name' => gT("Edit default anwers"),
            'icon' => 'icon-defaultanswers',
        ];
    }
}

$topbar['alignment']['left']['buttons'] = $buttons;

$finalJSON = [
  'permission' => $permissions,
  'topbar' => $topbar
];

header("Content-Type: application/json");
echo json_encode($finalJSON);
?>
