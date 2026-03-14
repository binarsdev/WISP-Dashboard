<?php
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) { header("Location:../admin.php?id=login"); } else {
  $s = $API->comm("/ppp/secret/print", array("?.id" => "$secretbyname"));
  $sec = $s[0];
  $profiles = $API->comm("/ppp/profile/print");
  if (isset($_POST['name'])) {
    $API->comm("/ppp/secret/set", array(
      ".id" => $secretbyname,
      "name" => $_POST['name'],
      "password" => $_POST['pass'],
      "profile" => $_POST['profile'],
      "local-address" => $_POST['localaddr'],
      "remote-address" => $_POST['remoteaddr'],
      "comment" => $_POST['comment'],
    ));
    echo "<script>window.location='./?ppp=secrets&session=".$session."'</script>";
  }
}
?>
<div class="row"><div class="col-8"><div class="card"><div class="card-header"><h3><i class="fa fa-edit"></i> Edit PPPoE Secret</h3></div><div class="card-body">
<form method="post" action=""><a class="btn bg-warning" href="./?ppp=secrets&session=<?= $session; ?>"><i class="fa fa-close"></i> <?= $_close ?></a>
<button class="btn bg-primary" type="submit"><i class="fa fa-save"></i> <?= $_save ?></button><table class="table">
<tr><td>Name</td><td><input class="form-control" name="name" value="<?= $sec['name']; ?>" required></td></tr>
<tr><td>Password</td><td><input class="form-control" name="pass" value="<?= $sec['password']; ?>" required></td></tr>
<tr><td>Profile</td><td><select class="form-control" name="profile"><option><?= $sec['profile']; ?></option><?php foreach($profiles as $p){echo "<option>".$p['name']."</option>";} ?></select></td></tr>
<tr><td>Local Address</td><td><input class="form-control" name="localaddr" value="<?= $sec['local-address']; ?>"></td></tr>
<tr><td>Remote Address</td><td><input class="form-control" name="remoteaddr" value="<?= $sec['remote-address']; ?>"></td></tr>
<tr><td>Comment</td><td><input class="form-control" name="comment" value="<?= $sec['comment']; ?>"></td></tr>
</table></form></div></div></div></div>
