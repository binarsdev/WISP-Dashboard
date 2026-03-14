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
  function parseMikhmonScriptLine($line)
  {
    $line = trim($line);
    if ($line == "" || strpos($line, "add") !== 0) {
      return false;
    }

    $result = array(
      "name" => "",
      "password" => "",
      "profile" => "",
      "limit-uptime" => "",
      "limit-bytes-total" => "",
      "comment" => "",
    );

    preg_match_all('/([a-zA-Z\-]+)="([^"]*)"/', $line, $matches, PREG_SET_ORDER);
    if (!is_array($matches) || count($matches) == 0) {
      return false;
    }

    foreach ($matches as $match) {
      $key = trim($match[1]);
      $value = trim($match[2]);
      if (isset($result[$key])) {
        $result[$key] = $value;
      }
    }

    if ($result["name"] == "" || $result["profile"] == "") {
      return false;
    }

    return $result;
  }

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
        $uname = "";
        $upass = "";
        $uprofile = "";
        $utimelimit = "";
        $udatalimit = "";
        $ucomment = "";

        if (count($row) >= 3) {
          $uname = trim($row[0]);
          $upass = trim($row[1]);
          $uprofile = trim($row[2]);
          $utimelimit = isset($row[3]) ? trim($row[3]) : "";
          $udatalimit = isset($row[4]) ? trim($row[4]) : "";
          $ucomment = isset($row[5]) ? trim($row[5]) : "";
        } else {
          $scriptData = parseMikhmonScriptLine($row[0]);
          if ($scriptData !== false) {
            $uname = $scriptData["name"];
            $upass = $scriptData["password"];
            $uprofile = $scriptData["profile"];
            $utimelimit = $scriptData["limit-uptime"];
            $udatalimit = $scriptData["limit-bytes-total"];
            $ucomment = $scriptData["comment"];
          }
        }

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
      $message = "Failed to open file.";
    }
  }
}
?>

<div class="row">
<div class="col-12">
<div class="card box-bordered">
  <div class="card-header">
    <h3><i class="fa fa-upload"></i> Import Hotspot Users (CSV/TXT)</h3>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" action="">
      <div class="mr-b-10">
        <a class="btn bg-warning" href="./?hotspot=users&profile=all&session=<?= $session; ?>"><i class="fa fa-close"></i> <?= $_close ?></a>
        <button class="btn bg-primary" type="submit" name="importusers"><i class="fa fa-upload"></i> Import</button>
      </div>
      <div class="mr-b-10">
        <input class="form-control" type="file" name="usercsv" accept=".csv,.txt,text/csv,text/plain" required>
      </div>
      <small>Expected format: CSV (Username, Password, Profile, Time Limit, Data Limit, Comment) or TXT script export from Mikhmon.</small>
    </form>

    <?php if ($message != "") { ?>
      <div class="mr-t-10"><b><?= $message; ?></b></div>
    <?php } ?>
  </div>
</div>
</div>
</div>
