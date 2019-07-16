<?php
$languages   = $oSurvey->allLanguages;
$permissions = [];
$buttons     = [];
$topbar = [
    'alignment' => [
      'left'  => [
        'buttons' => []
      ],
      'right' => [
        'buttons' => []
      ],
    ]
];

  if (count($languages) > 1) {
    if ($oSurvey->active == 'N') {
      // Preview Survey Button
      $title = 'preview_survey';
      $name  =  gT('Preview survey');
    } else {
      // Execute Survey Button
      $title = 'execute_survey';
      $name  = gT('Execute survey');
    }

    $buttons[$title] = [];
    foreach($languages as $language) {
      $buttons[$title] = [
        'url' => $this->createUrl("survey/index", array(
                  'sid'     =>  $sid,
                  'newtest' => "Y",
                  'lang'    => $language)),
        'icon' => 'fa fa-cog',
        'name' => $name,
      ];
  }
} else {

  if ($oSurvey->active == 'N') {
    // Preview Survey Button
    $title = 'preview_survey';
    $name  = gT('Preview survey');
  } else {
    // Execute Survey Button
    $title = 'execute_survey';
    $name  = gT('Execute survey');
  }

  $buttons[$title] = [
    'url' => $this->createUrl("survey/index", array(
              'sid'=>$sid,
              'newtest'=>"Y",
              'lang'=>$oSurvey->language)),
    'name' => $name,
    'icon' => 'fa fa-cog',
  ];

  array_push($topbar['alignment']['left']['buttons'], $buttons[$title]);
}

// Read Permission
$hasReadPermission = Permission::model()->hasSurveyPermission($sid, 'surveycontent', 'update');
if ($hasReadPermission) {
  $permissions['read'] = ['read' => $hasReadPermission];
  $buttons['preview_question_group'] = [];

  if (count($languages) > 1) {
    // Preview Question Group Button
    foreach($languagelist as $language) {
      $buttons['preview_question_group'] = [
        'url'  => $this->createUrl("survey/index/action/previewgroup/sid/{$sid}/gid/{$gid}/lang/" . $language),
        'name' => gT('Preview question group'),
        'icon' => 'fa fa-cog',
      ];
    }
  } else {
      $buttons['preview_question_group'] = [
        'url'  => $this->createUrl("survey/index/action/previewgroup/sid/$sid/gid/$gid/"),
        'name' => gT('Preview question group'),
        'icon' => 'fa fa-cog',
    ];
  }
  array_push($topbar['alignment']['left']['buttons'], $buttons['preview_question_group']);
}

// Right Buttons (only shown for question group
if (isset($questiongroupbar['buttons']['view'])) {
    if ($hasReadPermission) {
      // Check Survey Logic Button
      $buttons['check_survey_logic'] = [
        'url'  => $this->createUrl("admin/expressions/sa/survey_logic_file/sid/{$sid}/gid/{$gid}/"),
        'name' => gT("Check survey logic for current question group"),
        'icon' => 'icon-expressionmanagercheck',
      ];

      array_push($topbar['alignment']['right']['buttons'], $buttons['check_survey_logic']);
    }

    $hasDeletePermission = Permission::model()->hasSurveyPermission($sid, 'surveycontent', 'delete');
    if ($hasDeletePermission) {
      $permissions['delete'] = [ 'delete' => $hasDeletePermission];

      if (($sumcount4 == 0 && $activated != "Y") || $activated != "Y") {
          // has question
          if (empty($condarray)) {
            // can delete group and question
            $buttons['delete_current_question_group'] = [
              'url' => $this->createUrl("admin/questiongroups/sa/delete/", ["surveyid" => $sid, "gid"=>$gid]),
              'type' => 'modal',
              'message' => gT("Deleting this group will also delete any questions and answers it contains. Are you sure you want to continue?", "js"),
              'icon' => 'fa fa-trash',
              'name' => gT("Delete current question group"),
            ];
          } else {
            // there is at least one question having a condition on its content
            $buttons['delete_current_question_group'] = [
              'url' => '',
              'title' => gT("Impossible to delete this group because there is at least one question having a condition on its content"),
              'icon' => 'fa fa-trash',
              'name' => gT("Delete current question group"),
            ];
          }
      } else {
        // Activated
        $buttons['delete_current_question_group'] = [
          'title' => gT("You can't delete this question group because the survey is currently active."),
          'icon'  => 'fa fa-trash',
          'name'  => gT("Delete current question group"),
        ];
      }
    }
    array_push($topbar['alignment']['right']['buttons'], $buttons['delete_current_question_group']);
}

$hasExportPermission = Permission::model()->hasSurveyPermission($sid, 'surveycontent', 'export');
if ($hasExportPermission) {
  $permissions['update'] = ['export' => $hasExportPermission];

  $buttons['export'] = [
    'url' => $this->createUrl("admin/export/sa/group/surveyid/$sid/gid/$gid"),
    'icon' => 'icon-export',
    'name' => gT("Export this question group"),
  ];

  array_push($topbar['alignment']['right']['buttons'], $buttons['export']);
}


$finalJSON = [
  'permission' => $permissions,
  'topbar' => $topbar
];

header("Content-Type: application/json");
echo json_encode($finalJSON);
?>
