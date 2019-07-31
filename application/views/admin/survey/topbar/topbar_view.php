<div id="vue-topbar-container" class="container-fluid" style="width: 100%">
  <topbar
    :sid  = '<?php echo $sid ?? 0?>'
    :gid  = '<?php echo $gid ?? 0 ?>'
    :qid  = '<?php echo $qid ?? 0 ?>'
    type  = '<?php echo $topBarType ?>'
  />
</div>
