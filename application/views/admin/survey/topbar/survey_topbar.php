<?php
$permissions  = [];
$buttonsgroup = [];
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

// Left Buttons for Survey Summary
  // TODO: SurveyBar Activation Buttons
  // views/admin/survey/surveybar_activation.php
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
  if ($countLanguage > 1) {
    // TODO: Multinlinguage
    // TODO: BTN-GROUP (implemented in Vue JS as Component, has to be in the right array structure, to render it correctly.)
    // <?php if (count($oSurvey->allLanguages) > 1):
    // <div class="btn-group"> -->
    // <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> -->
    // <span class="icon-do" ></span> -->
    //  echo $icontext;
    //  <span class="caret"></span> -->
    //</button>
    //<ul class="dropdown-menu" style="min-width : 252px;">
    //<?php foreach ($oSurvey->allLanguages as $tmp_lang):
    //<li>
    //  <a target='_blank' href='<?php echo $this->createUrl("survey/index", array('sid'=>$oSurvey->sid, 'newtest'=>"Y", 'lang'=>$tmp_lang)); '>
    //    echo getLanguageNameFromCode($tmp_lang, false);
    //</a>
    //</li>
    //endforeach;
    //</ul>
    //</div>
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

}

// tools
// views/admin/surveybar_tools.php
$buttonsgroup['tools'] = [
  'class' => 'btn-group hidden-xs',
  'main_button' => [
    'id'            => 'ls-tools-button',
    'class'         => 'dropdown-toggle',
    'datatoggle'   => 'dropdown',
    'ariahaspopup' => 'true',
    'ariaexpanded' => 'false',
    'icon'          => 'icon-tools',
    'iconclass'    => 'caret',
    'name'          => gT('Tools'),
  ],
    'dropdown' => [
      'class' => 'dropdown-menu',
      'arialabelledby' => 'ls-tools-button',
      'items' => [],
  ],
];

if ($hasDeletePermission) {
  $buttons['delete_survey'] = [
    'url' => $this->createUrl("admin/survey/sa/delete/surveyid/{$sid}"),
    'icon' => 'fa fa-trash',
    'name' => gT('Delete survey'),
  ];
  array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['delete_survey']);
}

if ($hasSurveyTranslatePermission) {
  if ($hasAdditionalLanguages) {
      // Quick-translation
      $buttons['quick_translation'] = [
        'url' => $this->createUrl("admin/translate/sa/index/surveyid/{$sid}"),
        'icon' => 'fa fa-language',
        'name' => gT('Quick-translation'),
     ];
     array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['quick_translation']);
  } else {
    // Quick-translation disabled
    // TODO: In Vue onClick Alert hinzufügen
    $buttons['quick_translation'] = [
      'url' => '#',
      'type' => 'alert',
      'alerttext' => gT('Currently there are no additional languages configured for this survey.'),
      'icon' => 'fa fa-language',
      'name' => gT('Quick-translation'),
   ];
   array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['quick_translation']);
  }
}

if ($hasSurveyContentPermission) {
  if ($conditionsCount > 0) {
    // Condition
    $buttons['reset_conditions'] = [
      'url'  => $this->createUrl("/admin/conditions/sa/index/subaction/resetsurveylogic/surveyid/{$sid}"),
      'icon' => 'icon-resetsurveylogic',
      'name' => gT("Reset conditions"),
    ];
    array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['reset_conditions']);
  } else {
    // Condition disabled
    // TODO: alert onlick vue
    $buttons['reset_conditions'] = [
      'url' => '#',
      'type' => 'alert',
      'alerttext' => gT("Currently there are no conditions configured for this survey."),
      'icon' => 'icon-resetsurveylogic',
      'name' => gT("Reset conditions"),
    ];
    array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['reset_conditions']);
  }
}

// TODO: extraToolsMenuItems Plugin?
// TODO: menues from database

if ($hasSurveyReadPermission) {
  if ($oneLanguage) {
    // Survey Logic File
    $buttons['survey_logic_file'] = [
      'url' => $this->createUrl("admin/expressions/sa/survey_logic_file/sid/$sid/"),
      'icon' => 'icon-expressionmanagercheck',
      'name' => gT("Survey logic file"),
    ];
    array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['survey_logic_file']);
  } else {
    // Multiple languages
    // TODO: Multiple languages
  }
}

if (!$isActive && $hasSurveyContentPermission) {
  // Divider
  $buttons['divider'] = [
    'role' => 'seperator',
    'class' => 'divider',
  ];
  array_push($buttonsgroup ['tools']['dropdown']['items'], $buttons['divider']);

  // Regenerate question codes
  $buttons['question_codes'] = [
    'class' => 'dropdown-header',
    'name'  => gT('Regenerate question codes'),
  ];
  array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['question_codes']);

  // Straight
  $buttons['straight'] = [
    'url'   => $this->createUrl("/admin/survey/sa/regenquestioncodes/surveyid/{$sid}/subaction/straight"),
    'icon' => 'icon-resetsurveylogic',
    'name'  => gT('Straight'),
  ];
  array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['straight']);

  // By Question Group
  $buttons['by_question_group'] = [
    'url' => $this->createUrl("/admin/survey/sa/regenquestioncodes/surveyid/{$sid}/subaction/bygroup"),
    'name' => gT('By question group'),
    'icon' => 'icon-resetsurveylogic',
  ];

  array_push($buttonsgroup['tools']['dropdown']['items'], $buttons['by_question_group']);
}
array_push($topbar['alignment']['left']['buttons'], $buttonsgroup['tools']);

// Token
if ($hasSurveyTokensPermission) {
  $buttons['survey_participants'] = [
    'url'   => $this->createUrl("admin/tokens/sa/index/surveyid/$sid"),
    'class' => 'pjax btntooltip',
    'icon'  => 'fa fa-user',
    'name'  => gT('Survey participants'),
  ];
  array_push($topbar['alignment']['left']['buttons'], $buttons['survey_participants']);
}

// TODO: Statistics 
// TODO: Implement active Statistics for active surveys.
if ($isActive) {
  $buttonsgroup['statistics'] = [
    'class' => 'btn-group',
    'main_button' => [
      'class' => 'dropdown-toggle',
      'datatoggle'   => 'dropdown',
      'ariahaspopup' => true,
      'ariaexpanded' => false,
      'icon' => 'icon-responses',
      'name' => gT('Responses'),
      'iconclass' => 'caret',
    ],
    'dropdown' => [],
  ];
} else {
  $buttonsgroup['statistics'] = [
    'class' => 'btn-group',
    'main_button' => [
      'class' => 'readonly',
      'name'  => gT('Responses'),
      'datatoggle'    => 'tooltip',
      'dataplacement' => 'bottom',
      'title'     => gT('This survey is not active - no responses are available.'),
      'iconclass' => 'caret',
    ],
  ];

  array_push($topbar['alignment']['left']['buttons'], $buttonsgroup['statistics']);
}

$finalJSON = [
  'permissions' => $permissions,
  'topbar'      => $topbar,
];

header('Content-Type: application/json');
echo json_encode($finalJSON);
?>
