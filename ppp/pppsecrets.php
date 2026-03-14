<?php
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {
  $getsecret = $API->comm("/ppp/secret/print");
  $TotalReg = count($getsecret);
}
?>
<div class="row"><div class="col-12"><div class="card"><div class="card-header">
<h3><i class="fa fa-user"></i> <?= $_ppp_secrets ?> | <a href="./?ppp=addsecret&session=<?= $session; ?>"><i class="fa fa-plus-square"></i> <?= $_add ?></a></h3>
</div><div class="card-body">
<div class="w-6"><input id="filterTable" type="text" class="form-control" placeholder="Search.."></div>
<div class="overflow box-bordered mr-t-10" style="max-height:75vh"><table id="dataTable" class="table table-bordered table-hover text-nowrap">
<thead><tr><th></th><th>Service</th><th>Name</th><th>Password</th><th>Profile</th><th>Local Address</th><th>Remote Address</th><th>Comment</th></tr></thead><tbody>
<?php
for ($i=0; $i<$TotalReg; $i++) {
  $s=$getsecret[$i]; $id=$s['.id']; $name=$s['name']; $disabled=$s['disabled'];
  echo "<tr><td style='text-align:center;'>";
  echo "<i class='fa fa-minus-square text-danger pointer' onclick=\"if(confirm('Remove PPP secret ($name)?')){loadpage('./?remove-pppsecret=$id&session=$session')}\"></i>&nbsp;&nbsp;&nbsp;";
  if ($disabled == "true") {
    echo "<span class='text-warning pointer' onclick=\"loadpage('./?enable-pppsecret=$id&session=$session')\" title='Enable'><i class='fa fa-lock'></i></span>";
  } else {
    echo "<span class='pointer' onclick=\"loadpage('./?disable-pppsecret=$id&session=$session')\" title='Disable'><i class='fa fa-unlock'></i></span>";
  }
  echo "</td>";
  echo "<td>".$s['service']."</td>";
  echo "<td><a href='./?secret=$id&session=$session'><i class='fa fa-edit'></i> ".$name."</a></td>";
  echo "<td>".$s['password']."</td>";
  echo "<td>".$s['profile']."</td>";
  echo "<td>".$s['local-address']."</td>";
  echo "<td>".$s['remote-address']."</td>";
  echo "<td>".$s['comment']."</td></tr>";
}
?>
</tbody></table></div></div></div></div></div>
