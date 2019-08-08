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
    // TODO: BTN-GROUP
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

  // Display/Export Part
if ($hasSurveyExportPermission) {

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

  $exportItems = [
    'survey_structure' => [
      'title' => gT('Survey structure (.lss)'),
      'details' => [
        'p' => gT("This export will dump all the groups, questions, answers and conditions for your survey into a .LSS file (which is basically an XML file). This dump file can be used with the 'Import survey' feature when creating a new survey."),
        'p' => gT("A survey which uses a custom theme will import fine, but the template it refers to will not exist on the new server. In that case the system will use the global default theme."),
        'pb' => gT("Please note: This file does not contain any collected responses."),
      ],
      'url' => $this->createUrl("admin/export/sa/survey/action/exportstructurexml/surveyid/".$sid),
      'download' => true,
    ],
  ];

  if(($respstatsread && $hasSurveyExportPermission)) {
    if ($isActive) {
      $exportItems['surveyarchive'] = [
        'title' => gT("Survey archive (.lsa)"),
        'details' => [
          'p' => gT("This export is intended to create a complete backup of an active survey for archival purposes."),
          'p' => gT("It will include the following data in a ZIP file ending with '.lsa'."),
          'ul' => [
            'li' => gT("Survey structure"),
            'li' => gT("Response data (Attention: Doesn't include files uploaded in a file upload question. These have to be exported separately."),
            'li' => gT("Survey participant data (if available)"),
            'li' => gT("Timings (if activated)"),
          ],
          'url' => $this->createUrl("admin/export/sa/survey/action/exportarchive/surveyid/".$sid),
          'download' => true,
        ],
      ];
    } else {
      $exportItems['surveyarchive'] = [
        'title' => gT("Survey archive - only available for active surveys"),
        'class' => 'disabled',
        'url'   => '#',
        'download' => false,
        'deactivated' => true,
      ];
    }
  }

  $buttonsgroup['display_export'] = [
      'class' => 'btn-group hidden-xs',
      'main_button' => [
        'name' => gT('Display/Export'),
        'url'  => '',
        'icon' => 'fa fa-folder-open',
        'type' => 'modal',
      ],
      'modal' => [
        'component_name' => 'display-export',
        'title' => gT('Display/Export'),
        'preview_title' => gT('Export type'),
        'current_selected_item' => gT("Display/Export"),
        'items' => $exportItems,
        'buttons' => [
          'close' => [
            'name' => gT('Close'),
          ],
          'export' => [
            'name' => gt('Export'),
            'class' => 'btn-success',
          ],
        ],
      ],
  ];
  // Display/Export Button
  array_push($topbar['alignment']['left']['buttons'], $buttonsgroup['display_export']);
}

$finalJSON = [
  'permissions' => $permissions,
  'topbar'      => $topbar,
];

header('Content-Type: application/json');
echo json_encode($finalJSON);
?>
