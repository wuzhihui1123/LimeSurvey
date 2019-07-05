<?php 
    $permissions = [];

    $hasReadPermission = Permission::model()->hasSurveyPermission($surveyid, 'surveycontent', 'read');
    if ($hasReadPermission) {
        $readPermission = ['read', $hasReadPermission];
        array_push($permissions, $readPermission);
    }
    
    $hasDeletePermission =  Permission::model()->hasSurveyPermission($surveyid,'surveycontent','delete' );
    if ($hasDeletePermission) {
        $deletePermission = ['delete', $hasDeletePermission];
        array_push($permissions, $deletePermission);
    }

    $hasExportPermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','export');
    if ($hasExportPermission) {
        $exportPermission = ['export', $hasExportPermission];
        array_push($permissions, $exportPermission);
    }

    $hasCopyPermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','create');
    if ($hasCopyPermission) {
        $copyPermission = ['copy', $hasCopyPermission];
        array_push($permissions, $copyPermission);
    }

    $hasUpdatePermission = Permission::model()->hasSurveyPermission($surveyid,'surveycontent','update');
    if ($hasUpdatePermission) {
        $updatePermission = ['update', $hasUpdatePermission];
        array_push($permissions, $updatePermission);
    }

    $permissionsJSON = json_encode($permissions);
?>

<div id="vue-topbar-container">
    <topbar permissions='<?php echo $permissionsJSON ?>'></topbar>
</div>
