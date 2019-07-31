<?php
$permissions = [];
$buttons = [];
$topbar  = [
  'alignment' => [
    'left' => [
      'buttons' => [],
    ],
    'right' => [
      'buttons' => [],
    ],
  ],
];

  // TODO: Get SurveyBarAddGroupQuestions
  // App()->getController()->renderPartial(
  //           '/admin/survey/surveybar_addgroupquestion',
  //           [
  //               'surveybar'      => $surveybar,
  //               'oSurvey'        => $oSurvey,
  //               'surveyHasGroup' => isset($surveyHasGroup) ? $surveyHasGroup : false
  //           ]
  //       );

  // Left Buttons for Survey Summary
    // TODO: SurveyBar Activation Buttons
    // Survey Activation
    if (!$isActive) {

      $hasUpdatePermission = Permission::model()->hasSurveyPermission($sid, 'surveyactivation', 'update');
      // activate
      if ($canactivate) {
        $buttons['activate_survey'] = [
          'url'  => $this->createUrl("admin/survey/sa/activate/surveyid/$sid"),
          'name' => gT('Activate this survey'),
          'id' => 'ls-activate-survey',
          'class' => 'btn-success',
        ];
        array_push($topbar['alignment']['left']['buttons'], $buttons['activate_survey']);

        // cant activate
      } else if ($hasUpdatePermission) {
        $permissions['update'] = ['update' => $hasUpdatePermission];
        // TODO: ToolTip for cant activate survey
      }
    } else {
      // activate expired survey
      if ($expired) {
          // TODO: ToolTip for expired survey
      } else if ($notstarted) {
          // TODO: ToolTip for not started survey
      }

      // <!-- Stop survey -->
      if ($canactivate) {
        $buttons['stop_survey'] = [
          'url' => $this->createUrl("admin/survey/sa/deactivate/surveyid/$sid"),
          'class' => 'btn-danger btntooltip',
          'icon' => 'fa fa-stop-circle',
          'name' => gT("Stop this survey"),
        ];
        array_push($topbar['alignment']['left']['buttons'], $buttons['stop_survey']);
      }
    }

    if ($isActive || $hasSurveyContentPermission) {
      // Preview Survey
      if ($countLanguage > 1) {
        // TODO: Multinlinguage
      } else {
        // TODO: Unique Language
        $buttons[$contextbutton] = [
          'class' => 'btntooltip',
          'url'   => $this->createUrl("survey/index",
            array('sid'=>$sid, 'newtest'=>"Y", 'lang'=>$language)),
          'icon' => 'fa fa-cog',
          'name' => $context,
          'accesskey' => 'd',
          'target'=>'_blank',
        ];
        array_push($topbar['alignment']['left']['buttons'], $buttons[$contextbutton]);
      }
      // Execute Survey
    }
    $finalJSON = [
      'permissions' => $permissions,
      'topbar'      => $topbar,
    ];

    header('Content-Type: application/json');
    echo json_encode($finalJSON);
?>
