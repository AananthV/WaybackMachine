<?php

  $ROOT_PATH = '.';

  require_once($ROOT_PATH . '/database.php');
  require_once($ROOT_PATH . '/config.php');

  function saveSnapshot() {
    if(
      !isset($_POST['url'])
    ) return json_encode(array(
        'Message' => 'ERROR: NO SNAPSHOT?'
    ));

    $url = $_POST['url'];

    $snap = file_get_contents($url);

    $snapshot_id = insertValues(
      'snapshots',
      array(
        'url' => $url
      )
    );

    if($snapshot_id !== false) {
      fopen('snaps/snap-' . $snapshot_id . '.html', 'w');
      file_put_contents('snaps/snap-' . $snapshot_id . '.html', $snap);
      exec('\Users\aanan\Desktop\GnuWin32\bin\wget --directory-prefix=C:\\xampp\htdocs\wayback_machine\snaps\snap_'. $snapshot_id . '\ -E -H -k -K -p -nd --no-check-certificate ' . $url . ' 2>&1', $options);
      //echo implode($options);
      return json_encode(array(
            'Message' => 'SAVED'
      ));
    }
    else return json_encode(array(
        'Message' => 'ERROR'
    ));
  }

  echo saveSnapshot();

?>
