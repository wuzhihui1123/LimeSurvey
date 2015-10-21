<div class='menubar surveybar' id="tokenbarid">
    <div class='row container-fluid'>
        <?php if(isset($menu) && !$menu['edition']): ?>
            <div class="col-md-12">
            <!-- Show summary information -->
            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'read')): ?>
                <a class="btn btn-default" href='<?php echo $this->createUrl("admin/responses/sa/index/surveyid/$surveyid"); ?>' role="button">
                    <span class="glyphicon glyphicon-list-alt text-success"></span>
                    <?php eT("Summary"); ?>
                </a>
            <?php endif;?>

            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'read')): ?>


                <!-- Display Responses -->
                <?php if (count($tmp_survlangs) < 2): ?>
                    <a class="btn btn-default" href='<?php echo $this->createUrl("admin/responses/sa/browse/surveyid/$surveyid"); ?>' role="button">
                        <span class="glyphicon glyphicon-list text-success"></span>
                        <?php eT("Display Responses"); ?>
                    </a>
                <?php else:?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-add text-success"></span>
                        <?php eT("Responses"); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($tmp_survlangs as $tmp_lang): ?>
                        <li>
                            <a href="<?php echo $this->createUrl("admin/responses/sa/browse/surveyid/$surveyid/browselang/$tmp_lang"); ?>" accesskey='b'>
                                <?php echo getLanguageNameFromCode($tmp_lang, false); ?>
                             </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <?php endif;?>


                <!-- Display Last 50 Responses -->
                <?php if (count($tmp_survlangs) < 2): ?>
                    <a class="btn btn-default" href='<?php echo $this->createUrl("admin/responses/sa/browse/surveyid/$surveyid/start/0/limit/50/order/desc"); ?>' role="button">
                        <span class="icon-viewlast text-success"></span>
                        <?php eT("Last 50 Responses"); ?>
                    </a>
                <?php else:?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-viewlast text-success"></span>
                        <?php eT("Last 50 Responses");?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <?php foreach ($tmp_survlangs as $tmp_lang):?>
                                <li>
                                    <a href="<?php echo $this->createUrl("admin/responses/sa/browse/surveyid/$surveyid/start/0/limit/50/order/desc/browselang/$tmp_lang"); ?>" accesskey='b'>
                                        <?php echo getLanguageNameFromCode($tmp_lang, false); ?>
                                    </a>
                                </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <?php endif;?>
            <?php endif;?>


            <!-- Dataentry Screen for Survey -->
            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'create')): ?>
                <a class="btn btn-default" href='<?php echo $this->createUrl("admin/dataentry/sa/view/surveyid/$surveyid"); ?>' role="button">
                    <span class="fa fa-keyboard-o text-success"></span>
                    <?php eT("Dataentry"); ?>
                </a>
            <?php endif;?>

            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'statistics', 'read')): ?>
                <!-- Get statistics from these responses -->
                <a class="btn btn-default" href='<?php echo $this->createUrl("admin/statistics/sa/index/surveyid/$surveyid"); ?>' role="button">
                    <span class="glyphicon glyphicon-stats text-success"></span>
                    <?php eT("Statistics"); ?>
                </a>

                <!-- Get time statistics from these responses -->
                <?php if ($thissurvey['savetimings'] == "Y"):?>
                    <a class="btn btn-default" href='<?php echo $this->createUrl("admin/responses/sa/time/surveyid/$surveyid"); ?>' role="button">
                        <span class="glyphicon glyphicon-time text-success"></span>
                        <?php eT("Get time statistics from these responses"); ?>
                    </a>
                <?php endif;?>
            <?php endif;?>


            <!-- Export -->
            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'export')): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-export text-success"></span>
                        <?php eT("Export"); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">

                        <!-- Export results to application -->
                        <li>
                            <a href='<?php echo $this->createUrl("admin/export/sa/exportresults/surveyid/$surveyid"); ?>'>
                                <?php eT("Export results to application"); ?>
                            </a>
                        </li>

                        <!-- Export results to a SPSS/PASW command file -->
                        <li>
                            <a href='<?php echo $this->createUrl("admin/export/sa/exportspss/sid/$surveyid"); ?>'>
                                <?php eT("Export results to a SPSS/PASW command file"); ?>
                            </a>
                        </li>

                        <!-- Export a VV survey file -->
                        <li>
                            <a href='<?php echo $this->createUrl("admin/export/sa/vvexport/surveyid/$surveyid"); ?>'>
                                <?php eT("Export a VV survey file"); ?>
                            </a>
                        </li>

                    </ul>
                </div>
            <?php endif;?>


            <!-- Import -->
            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'create')): ?>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-import text-success"></span>
                        <?php eT("Import"); ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">

                        <!-- Import responses from a deactivated survey table -->
                        <li>
                            <a href='<?php echo $this->createUrl("admin/dataentry/sa/import/surveyid/$surveyid"); ?>' role="button">
                                <?php eT("Import responses from a deactivated survey table"); ?>
                            </a>
                        </li>

                        <!-- Import a VV survey file -->
                        <li>
                            <a href='<?php echo $this->createUrl("admin/dataentry/sa/vvimport/surveyid/$surveyid"); ?>' role="button">
                                <?php eT("Import a VV survey file"); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif;?>


            <!-- View Saved but not submitted Responses -->
            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'read')): ?>
                <a class="btn btn-default" href='<?php echo $this->createUrl("admin/saved/sa/view/surveyid/$surveyid"); ?>' role="button">
                    <span class="icon-saved text-success"></span>
                    <?php eT("View Saved but not submitted Responses"); ?>
                </a>
            <?php endif;?>


            <!-- Iterate survey -->
            <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'delete')): ?>
                <?php if ($thissurvey['anonymized'] == 'N' && $thissurvey['tokenanswerspersistence'] == 'Y'): ?>
                    <a class="btn btn-default" href='<?php echo $this->createUrl("admin/dataentry/sa/iteratesurvey/surveyid/$surveyid"); ?>' role="button">
                        <span class="fa fa-repeat text-success"></span>
                        <?php eT("Iterate survey"); ?>
                    </a>
                <?php endif;?>
            <?php endif;?>
        </div>
        <?php else: ?>
        <div class="col-md-5 text-right col-md-offset-7">
            <?php if(isset($menu['save'])): ?>
                <a class="btn btn-success" href="#" role="button" id="save-button">
                    <span class="glyphicon glyphicon-ok"></span>
                    <?php eT("Save");?>
                </a>
                <a class="btn btn-default" href="#" role="button">
                    <span class="glyphicon glyphicon-saved"></span>
                    <?php eT("Save and close");?>
                </a>
            <?php endif;?>

            <?php if(isset($menu['export'])): ?>
                <a class="btn btn-success" href="#" role="button" id="save-button">
                    <span class="glyphicon glyphicon-download-alt"></span>
                    <?php eT("Export");?>
                </a>
            <?php endif;?>

            <?php if(isset($menu['import'])): ?>
                <a class="btn btn-success" href="#" role="button" id="save-button">
                    <span class="glyphicon glyphicon-upload"></span>
                    <?php eT("Import");?>
                </a>
            <?php endif;?>

            <?php if(isset($menu['stats'])):?>
                <a class="btn btn-success" href="#" role="button" id="save-button">
                    <span class="glyphicon glyphicon-stats"></span>
                    <?php eT("View statistics"); ?>
                </a>

                <a class="btn btn-default" href="#" role="button" id="save-button" onclick="window.open('<?php echo Yii::app()->getController()->createUrl("admin/statistics/sa/index/surveyid/$surveyid"); ?>', '_top')">
                    <span class="glyphicon glyphicon-refresh text-success"></span>
                    <?php eT("Clear"); ?>
                </a>

            <?php endif;?>
            <?php if (isset($menu['view'])): ?>
                <?php if ($exist): ?>
                    <a class="btn btn-default" href='<?php echo $this->createUrl("admin/dataentry/sa/editdata/subaction/edit/surveyid/{$surveyid}/id/{$id}/lang/$rlanguage"); ?>' role="button">

                        <span class="glyphicon glyphicon-pencil text-success"></span>
                        <?php eT("Edit this entry"); ?>
                    </a>
                    <?php if (Permission::model()->hasSurveyPermission($surveyid, 'responses', 'delete') && isset($rlanguage)): ?>
                    <a class="btn btn-default" href='#' role="button" onclick="if (confirm('<?php eT("Are you sure you want to delete this entry?", "js"); ?>')) { <?php echo convertGETtoPOST($this->createUrl("admin/dataentry/sa/delete/id/$id/sid/$surveyid")); ?>}">
                        <span class="glyphicon glyphicon-trash text-warning"></span>
                        <?php eT("Delete this entry"); ?>
                    </a>
                    <?php endif;?>

                    <?php if ($bHasFile): ?>
                    <a class="btn btn-default" href='<?php echo Yii::app()->createUrl("admin/responses",array("sa"=>"actionDownloadfiles","surveyid"=>$surveyid,"sResponseId"=>$id)); ?>' role="button" >
                        <span class="glyphicon  glyphicon-download-alt text-success"></span>
                        <?php eT("Delete this entry"); ?>
                    </a>
                    <?php endif;?>

                    <a class="btn btn-default" href='<?php echo $this->createUrl("admin/export/sa/exportresults/surveyid/$surveyid/id/$id"); ?>' role="button" >
                        <span class="icon-export text-success downloadfile"></span>
                        <?php eT("Export this Response"); ?>
                    </a>
                <?php endif;?>

            <?php if($previous) { ?>
            <a href='<?php echo $this->createUrl("admin/responses/sa/view/surveyid/$surveyid/id/$previous"); ?>' title='<?php eT("Show previous..."); ?>' >
                <span class="icon-databack text-success" title='<?php eT("Show previous..."); ?>'></span>
            </a>
            <?php } ?>
            <?php if($next) { ?>
                <a href='<?php echo $this->createUrl("admin/responses/sa/view/surveyid/$surveyid/id/$next"); ?>' title='<?php eT("Show next..."); ?>'>
                    <span class="icon-dataforward text-success" title='<?php eT("Show next..."); ?>'></span>
                </a>
            <?php } ?>

            <?php endif;?>

            <?php if(isset($menu) && $menu['close']): ?>
                <a class="btn btn-danger" href="<?php echo $this->createUrl("admin/responses/sa/index/surveyid/$surveyid"); ?>" role="button">
                    <span class="glyphicon glyphicon-close"></span>
                    <?php eT("Close");?>
                </a>
            <?php endif;?>
        </div>
        <?php endif;?>
    </div>
</div>
