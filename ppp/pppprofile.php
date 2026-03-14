<?php
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) { header("Location:../admin.php?id=login"); } else { $profiles=$API->comm('/ppp/profile/print'); }
?>
<div class="row"><div class="col-12"><div class="card"><div class="card-header"><h3><i class="fa fa-list"></i> <?= $_ppp_profiles ?> | <a href="./?ppp=add-profile&session=<?= $session; ?>"><i class="fa fa-plus-square"></i> <?= $_add ?></a></h3></div><div class="card-body">
<div class="overflow box-bordered" style="max-height:75vh"><table id="dataTable" class="table table-bordered table-hover text-nowrap"><thead><tr><th></th><th>Name</th><th>Local Address</th><th>Remote Address</th><th>Rate Limit</th><th>Only One</th></tr></thead><tbody>
<?php foreach($profiles as $p){ $id=$p['.id']; $name=$p['name']; echo "<tr><td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick=\"if(confirm('Remove profile ($name)?')){loadpage('./?remove-pprofile=$id&session=$session')}\"></i></td><td><a href='./?ppp=edit-profile&profile=$id&session=$session'><i class='fa fa-edit'></i> $name</a></td><td>".$p['local-address']."</td><td>".$p['remote-address']."</td><td>".$p['rate-limit']."</td><td>".$p['only-one']."</td></tr>"; } ?>
</tbody></table></div></div></div></div></div>
