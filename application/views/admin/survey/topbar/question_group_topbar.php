<?php
$languages   = $oSurvey->allLanguages;
$permissions = [];
$buttons     = [];
$topbar      = [
    'alignment' => [
      'left'  => [
        'buttons' => []
      ],
      'right' => [
        'buttons' => []
      ],
    ]
];
$topbarextended = [
  'alignment' => [
      'left' => [
        'buttons' => [],
      ],
      'right' => [
        'buttons' => [],
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

// TopBar Extended (second TopBar, which will swap if Event triggered)
$topbarextended['alignment']['left']['buttons'] = $topbar['alignment']['left']['buttons'];

// Save Buttons (right side)
if ($ownsSaveButton == true) {
  // Save Button
  $buttons['save'] = [
    'name' => gT('Save'),
    'icon' => 'fa fa-floppy-o',
    'url'  => '#',
    'id'   => 'save-button',
    'class' => 'btn-success',
  ];
  array_push($topbarextended['alignment']['right']['buttons'], $buttons['save']);
}

// // Save and Close Button
// if ($ownsSaveAndCloseButton) {
//   $button['save_and_close'] = [
//     'name' => gT('Save and close'),
//     'icon' => 'fa fa-check-square',
//     'url'  => '#',
//     'id'   => 'save-and-close-button',
//     'class' => 'btn-default',
//   ];
//   array_push($topbarextended['alignment']['right']['buttons'], $button['save_and_close']);
// }

    // Close Button
    // if (isset($questiongroupbar['closebutton']['url'])) {
    //   $button['close'] = [
    //     'name' => gT('Close'),
    //     'url'  => $questiongroupbar['closebutton']['url'],
    //     'icon' => 'fa fa-close',
    //     'class' => 'btn-danger',
    //     'id'   => 'close-button',
    //   ];
    //   array_push($topbarextended['alignment']['right']['buttons'], $button['close']);
    // }

    // Return Button
    // if (isset($questiongroupbar['returnbutton']['url'])) {
    //   $button['return'] = [
    //     'name' => gT('Return to survey list'),
    //     'url'  => $questiongroupbar['returnbutton']['url'],
    //     'class' => 'btn-default',
    //     'icon' => 'fa fa-step-backwards',
    //   ];
    //   array_push($topbarextended['alignment']['right']['buttons'], $button['return']);
    // }

$finalJSON = [
  'permission'     => $permissions,
  'topbar'         => $topbar,
  'topbarextended' => $topbarextended,
];

header("Content-Type: application/json");
echo json_encode($finalJSON);
?>
