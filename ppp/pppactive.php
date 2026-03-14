<?php
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) { header("Location:../admin.php?id=login"); } else { $act=$API->comm('/ppp/active/print'); }
?>
<div class="row"><div class="col-12"><div class="card"><div class="card-header"><h3><i class="fa fa-link"></i> <?= $_ppp_active ?></h3></div><div class="card-body"><div class="overflow box-bordered" style="max-height:75vh"><table id="dataTable" class="table table-bordered table-hover text-nowrap"><thead><tr><th></th><th>Name</th><th>Service</th><th>Caller ID</th><th>Address</th><th>Uptime</th></tr></thead><tbody>
<?php foreach($act as $a){$id=$a['.id'];$name=$a['name'];echo "<tr><td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick=\"if(confirm('Disconnect $name?')){loadpage('./?remove-pactive=$id&session=$session')}\"></i></td><td>$name</td><td>".$a['service']."</td><td>".$a['caller-id']."</td><td>".$a['address']."</td><td>".$a['uptime']."</td></tr>";} ?>
</tbody></table></div></div></div></div></div>
