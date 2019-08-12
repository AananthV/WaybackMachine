<?php

  $ROOT_PATH = '.';

  require_once($ROOT_PATH . '/database.php');
  require_once($ROOT_PATH . '/config.php');

  function getSnapshot() {
    if(
      !isset($_GET['id'])
    ) return json_encode(array(
        'Message' => 'ERROR: NO ID'
    ));

    header('/wayback_machine/snaps/snap_' . $_GET['id'] . '/');
  }

  echo getSnapshot();

?>
