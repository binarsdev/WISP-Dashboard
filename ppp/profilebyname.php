<?php
error_reporting(0);
$profid = $_GET['profile'];
if (!isset($_SESSION["mikhmon"])) { header("Location:../admin.php?id=login"); } else {
  $g = $API->comm('/ppp/profile/print', array('?.id'=>"$profid")); $p=$g[0];
  if (isset($_POST['name'])) {
    $API->comm('/ppp/profile/set', array(
      '.id'=>$profid,
      'name'=>$_POST['name'],
      'local-address'=>$_POST['localaddr'],
      'remote-address'=>$_POST['remoteaddr'],
      'rate-limit'=>$_POST['ratelimit'],
      'only-one'=>$_POST['onlyone'],
    ));
    echo "<script>window.location='./?ppp=profiles&session=".$session."'</script>";
  }
}
?>
<div class="row"><div class="col-8"><div class="card"><div class="card-header"><h3><i class="fa fa-edit"></i> Edit PPP Profile</h3></div><div class="card-body">
<form method="post"><a class="btn bg-warning" href="./?ppp=profiles&session=<?= $session; ?>"><i class="fa fa-close"></i> <?= $_close ?></a> <button class="btn bg-primary" type="submit"><i class="fa fa-save"></i> <?= $_save ?></button>
<table class="table"><tr><td>Name</td><td><input class="form-control" name="name" value="<?= $p['name']; ?>" required></td></tr><tr><td>Local Address</td><td><input class="form-control" name="localaddr" value="<?= $p['local-address']; ?>"></td></tr><tr><td>Remote Address</td><td><input class="form-control" name="remoteaddr" value="<?= $p['remote-address']; ?>"></td></tr><tr><td>Rate Limit</td><td><input class="form-control" name="ratelimit" value="<?= $p['rate-limit']; ?>"></td></tr><tr><td>Only One</td><td><select class="form-control" name="onlyone"><option value="<?= $p['only-one']; ?>"><?= $p['only-one']; ?></option><option value="yes">yes</option><option value="no">no</option></select></td></tr></table>
</form></div></div></div></div>
