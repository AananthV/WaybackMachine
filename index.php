<?php

  $ROOT_PATH = '.';

  require_once($ROOT_PATH . '/database.php');
  require_once($ROOT_PATH . '/config.php');

  function getSnapshots() {
    $snaps = getValues(
      'snapshots',
      array('id', 'timestamp', 'url')
    );

    return json_encode($snaps);
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title></title>
  </head>
  <body>
    <div class="input-group">
      <input type="url" class="form-control" id="url-input" value="" placeholder="URL">
      <div class="input-group-append">
        <button type="button" class="btn btn-success" onclick="save()">Save Snapshot!</button>
      </div>
    </div>
    <table class="table table-striped" id="snap-list"></table>
    <div class="embed-responsive embed-responsive-16by9">
      <iframe class="border border-dark" id="snap-site" src=""></iframe>
    </div>
  </body>
  <script type="text/javascript">

    let snaps = JSON.parse('<?php echo getSnapshots();?>');

    function loadSite(id) {
      document.querySelector('#snap-site').setAttribute('src', 'snaps/snap_' + id + '/');
    }

    function snapList() {
      let snapList = document.querySelector('#snap-list');
      snapList.innerHTML = '<tr><th>id</th><th>timestamp</th><th>url</th><th>view</th></tr>';
      for(let snap of snaps) {
        snapList.innerHTML += '<tr><td>' + snap.id + '</td><td>' + snap.timestamp + '</td><td>' + snap.url + '</td><td><button type="button" class="btn btn-success" onclick="loadSite(' + snap.id + ')">View</button></td></tr>'
      }
    }

    async function save() {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
          location.reload();
        }
      };
      xhttp.open("POST", "save_snapshot.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send('url=' + document.querySelector('#url-input').value);
    }

    function getPage() {
        return new Promise(function(resolve, reject) {
          let xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              resolve(this.responseText);
            }
          };
          xhttp.open("GET", window.location, true);
          xhttp.send();
        });
    }

    snapList();
  </script>
</html>
