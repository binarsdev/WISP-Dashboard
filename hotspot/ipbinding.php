<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);
if (!isset($_SESSION["mikhmon"])) {
	header("Location:../admin.php?id=login");
} else {

	$getbinding = $API->comm("/ip/hotspot/ip-binding/print");
	$TotalReg = count($getbinding);

	$countbinding = $API->comm("/ip/hotspot/ip-binding/print", array(
		"count-only" => "",
	));

	$editbinding = array();
	if ($editipbinding != "") {
		$geteditbinding = $API->comm("/ip/hotspot/ip-binding/print", array(
			"?.id" => "$editipbinding",
		));
		$editbinding = $geteditbinding[0];
	}
}

?>
<div class="row">
<div id="reloadbinding">
<div class="col-12">
<div class="card">
<div class="card-header">
	<h3><i class=" fa fa-address-book"></i> <?= $_ip_bindings ?> 
<?php
if ($countbinding < 2) {
	echo "$countbinding item";
} elseif ($countbinding > 1) {
	echo "$countbinding items";
};
?>
    </h3>
</div>
<div class="card-body">	   
<?php if ($editipbinding != "" && $editbinding != "") { ?>
<div class="box-bordered pd-10 mr-b-10">
	<form action="./" method="get">
		<input type="hidden" name="session" value="<?= $session; ?>">
		<input type="hidden" name="update-ip-binding" value="<?= $editbinding['.id']; ?>">
		<div class="row">
			<div class="col-12 col-md-3 mr-b-5">
				<label>MAC Address</label>
				<input type="text" name="set-binding-mac" class="form-control" value="<?= $editbinding['mac-address']; ?>" required>
			</div>
			<div class="col-12 col-md-3 mr-b-5">
				<label>Address</label>
				<input type="text" name="set-binding-ip" class="form-control" value="<?= $editbinding['address']; ?>" required>
			</div>
			<div class="col-12 col-md-3 mr-b-5">
				<label>Type</label>
				<select name="set-binding-type" class="form-control" required>
					<option value="regular" <?= $editbinding['type'] == "regular" ? "selected" : ""; ?>>regular</option>
					<option value="bypassed" <?= $editbinding['type'] == "bypassed" ? "selected" : ""; ?>>bypassed</option>
					<option value="blocked" <?= $editbinding['type'] == "blocked" ? "selected" : ""; ?>>blocked</option>
				</select>
			</div>
			<div class="col-12 col-md-3 mr-b-5">
				<label>Action</label><br>
				<button class="btn bg-success" type="submit"><i class="fa fa-save"></i> Save</button>
				<a class="btn bg-warning" href="./?hotspot=ipbinding&session=<?= $session; ?>"><i class="fa fa-times"></i> Cancel</a>
			</div>
		</div>
	</form>
</div>
<?php } ?>
<div class="w-6">
    <input id="filterTable" type="text" class="form-control" placeholder="Search..">
  </div>
<div class="overflow box-bordered mr-t-10" style="max-height: 75vh">  	   
<table id="dataTable" class="table table-bordered table-hover text-nowrap"> 
 <thead>
  <tr>
    <th></th>
    <th></th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> <?= $_name ?></th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> MAC Address</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Address</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> To Address</th>
    <th class="pointer" title="Click to sort"><i class="fa fa-sort"></i> Server</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody> 
<?php
for ($i = 0; $i < $TotalReg; $i++) {
	$binding = $getbinding[$i];
	$id = $binding['.id'];

	$maca = $binding['mac-address'];
	$addr = $binding['address'];
	$toaddr = $binding['to-address'];
	$server = $binding['server'];
	$commt = $binding['comment'];
	$bdisabled = $binding['disabled'];

	echo "<tr>";
	?>
  	<td style='text-align:center;'><i class='fa fa-minus-square text-danger pointer' onclick="if(confirm('Are you sure to delete (<?= $maca; ?>)?')){loadpage('./?remove-ip-binding=<?= $id . '&mac=' . $maca . '&addr=' . $addr; ?>&session=<?= $session; ?>')}else{}" title='Remove <?= $maca; ?>'></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
  	<?php

		if ($bdisabled == "true") {
			$uriprocess = "'./?enable-ip-binding=" . $id . "&session=" . $session . "'";
			echo "<span class='text-warning btnsmall pointer' title='Enable Binding " . $addr . "' onclick=loadpage(".$uriprocess.")><i class='fa fa-lock'></span></td>";
		} else {
			$uriprocess = "'./?disable-ip-binding=" . $id . "&session=" . $session . "'";
			echo "<span title='Disable Binding " . $addr . "' class='btnsmall pointer' onclick=loadpage(".$uriprocess.")><i class='fa fa-unlock '></span></td>";
		}
		echo "<td style='text-align:center;'>";
		if ($binding['bypassed'] == "true") {
			echo "<b style='color:#0091EA;'>P</b>";
		} else {
		}
		echo "</td>";
		echo "<td>" . $commt . "</td>";
		echo "<td>" . $maca . "</td>";
		echo "<td>" . $addr . "</td>";
		echo "<td>" . $toaddr . "</td>";
		echo "<td>" . $server . "</td>";
		echo "<td style='text-align:center;'>";
		echo "<a class='btn btn-sm' title='Edit Binding " . $maca . "' href='./?hotspot=ipbinding&edit-ip-binding=" . $id . "&session=" . $session . "'><i class='fa fa-edit'></i></a>";
		echo "</td>";
		echo "</tr>";
	}
	?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
<div class="modal-window" id="help" aria-hidden="true">
  <div>
  	<header><h1>Help</h1></header>
  	<a style="font-weight:bold;" href="#" title="Close" class="modal-close">X</a>
	<p> 
		    <?php if ($currency == in_array($currency, $cekindo['indo'])) { ?>
		      <ul>
		        <li>Masuk ke menu Hosts.</li>
		        <li>Klik IP Address yang ingin di binding.</li>
		      </ul>
		    <?php 
				} else { ?>
		      <ul>
		        <li>Go to Hosts menu.</li>
		        <li>Click the IP Address that you want to binding.</li>
		      </ul>
		    <?php 
				} ?>
	</p>
  </div>
</div>
</div>
</div>
