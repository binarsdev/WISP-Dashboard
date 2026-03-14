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

error_reporting(0);
ini_set('max_execution_time', 300);

if (!isset($_SESSION["mikhmon"])) {
  header("Location:../admin.php?id=login");
} else {
  $imported = 0;
  $skipped = 0;
  $message = "";

  if (isset($_POST['importusers']) && isset($_FILES['usercsv']) && $_FILES['usercsv']['tmp_name'] != "") {
    $handle = fopen($_FILES['usercsv']['tmp_name'], "r");

    if ($handle) {
      $header = fgetcsv($handle);
      $isExportHeader = false;
      if (is_array($header)) {
        $isExportHeader = (
          trim($header[0]) == "Username" &&
          trim($header[1]) == "Password" &&
          trim($header[2]) == "Profile"
        );
      }

      if (!$isExportHeader) {
        rewind($handle);
      }

      while (($row = fgetcsv($handle)) !== false) {
        if (count($row) < 3) {
          $skipped++;
          continue;
        }

        $uname = trim($row[0]);
        $upass = trim($row[1]);
        $uprofile = trim($row[2]);
        $utimelimit = trim($row[3]);
        $udatalimit = trim($row[4]);
        $ucomment = trim($row[5]);

        if ($uname == "" || $uprofile == "") {
          $skipped++;
          continue;
        }

        $exists = $API->comm("/ip/hotspot/user/print", array(
          "?name" => "$uname",
        ));

        if (count($exists) > 0) {
          $skipped++;
          continue;
        }

        $payload = array(
          "name" => "$uname",
          "password" => "$upass",
          "profile" => "$uprofile",
        );

        if ($utimelimit != "") {
          $payload["limit-uptime"] = "$utimelimit";
        }
        if ($udatalimit != "") {
          $payload["limit-bytes-total"] = "$udatalimit";
        }
        if ($ucomment != "") {
          $payload["comment"] = "$ucomment";
        }

        $API->comm("/ip/hotspot/user/add", $payload);
        $imported++;
      }
      fclose($handle);
      $message = "Imported: " . $imported . " | Skipped: " . $skipped;
    } else {
      $message = "Failed to open CSV file.";
    }
  }
}
?>

<div class="row">
<div class="col-12">
<div class="card box-bordered">
  <div class="card-header">
    <h3><i class="fa fa-upload"></i> Import Hotspot Users CSV</h3>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" action="">
      <div class="mr-b-10">
        <a class="btn bg-warning" href="./?hotspot=users&profile=all&session=<?= $session; ?>"><i class="fa fa-close"></i> <?= $_close ?></a>
        <button class="btn bg-primary" type="submit" name="importusers"><i class="fa fa-upload"></i> Import</button>
      </div>
      <div class="mr-b-10">
        <input class="form-control" type="file" name="usercsv" accept=".csv,text/csv" required>
      </div>
      <small>Expected format: Username, Password, Profile, Time Limit, Data Limit, Comment</small>
    </form>

    <?php if ($message != "") { ?>
      <div class="mr-t-10"><b><?= $message; ?></b></div>
    <?php } ?>
  </div>
</div>
</div>
</div>
