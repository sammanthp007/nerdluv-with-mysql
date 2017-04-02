<?php
require_once('./init.php');

include("top.html");

/* Get all singles */
$singles = file("singles.txt");

/* Get the info about user */
$user_personality = '';
$user_os = '';
$user_min_seek = 0;
$user_max_seek = 0;
$user_gender = '';
$user_age = 0;
$user_id = 0;

global $db;
$user_name = $_GET["name"];

$sql = "SELECT * FROM users where name = '" . $user_name . "';";
$all_users = mysqli_query($db, $sql);

if ($all_users->num_rows > 0) {
    while ($row = $all_users->fetch_assoc()) {
        $user_id = $row["id"];
        $user_gender = $row["gender"];
        $user_age = (int)$row["age"];

        /* get users personality type */
        $sql = "SELECT name FROM personalities WHERE user_id = ";
        $sql .= $user_id . ";";
        $response_personality = mysqli_query($db, $sql);
        $user_personality = $response_personality->fetch_assoc()["name"];

        /* get users fav os */
        $sql = "SELECT name FROM fav_os WHERE user_id = ";
        $sql .= $user_id . ";";
        $response_favos = mysqli_query($db, $sql);
        $user_os = $response_favos->fetch_assoc()["name"];

        /* get users min and max seek age */
        $sql = "SELECT min_age, max_age FROM seeking_age ";
        $sql .= "WHERE user_id = ";
        $sql .= $user_id . ";";
        $response_seek_ages = mysqli_query($db, $sql);
        $seek_ages = $response_seek_ages->fetch_assoc();
        $user_min_seek = (int)$seek_ages["min_age"];
        $user_max_seek = (int)$seek_ages["max_age"];
    }
}

echo $user_name . " " . $user_max_seek . " " . $user_os .  "\n";
echo $user_id. " " . $user_min_seek . " " .$user_personality . "\n";
echo $user_gender;

/* get opposite gender */
$match_gender = '';
if (strcmp($user_gender, 'M') === 0) {
    $match_gender = 'F';
    echo $match_gender;
} else {
    $match_gender = 'M';
}

$matches = array();

/* Get matches */
?>
<div>
<?php
$is_first = true;
/* Get others info */
$other_gender = $match_gender;
$other_age = 0;
$other_personality = '';
$other_os = '';
$other_min_seek = 0;
$other_max_seek = 0;

/* sql for the match */
$sql = "SELECT users.name, gender, age, ";
$sql .= "fav_os.name as os, ";
$sql .= "personalities.name as personality FROM users ";
$sql .= "JOIN fav_os ON users.id = fav_os.user_id ";
$sql .= "JOIN seeking_age ON users.id = seeking_age.user_id ";
$sql .= "JOIN personalities ON users.id = personalities.user_id ";
$sql .= "WHERE users.gender = ";
$sql .= "'" . $match_gender . "' ";
$sql .= "and users.age > ". $user_min_seek . " ";
$sql .= "and users.age < ". $user_max_seek . " ";
$sql .= "and seeking_age.min_age < " . $user_age . " ";
$sql .= "and seeking_age.max_age > " . $user_age . ";";

echo "\n" . $sql . "\n\n\n\n\n";

$results = mysqli_query($db, $sql);

if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        echo "\n";
        $p = array_keys($row);
        foreach ($p as $v) {
            echo $v . "\n";
            echo $row[$v];
        }

    }
}



    /* Check favorite OS */
    if($user_matches_others_choice && $other_matches_users_choice){
        if (strcmp($user_os, $other_os) === 0) {

            /* At least one personality type in common */
            $inRegex = "/[".$user_personality."]/";
            if (preg_match($inRegex, $other_personality) === 1) {
                $matches[] = $singles[$i];

                if ($is_first) {
?>
        <strong>Matches for <?= $_GET["name"] ?></strong><br>
<?php
                    $is_first = false;
                }
?>
  <div class="match">
      <img src="user.jpg" alt="photo"/>
      <div>
          <ul>
              <li><p><?= $other_info_array[0] ?></p></li>
              <li><strong>gender:</strong> <?= $other_gender ?></li>
              <li><strong> age:</strong> <?= $other_age ?> </li>
              <li><strong> type:</strong> <?= $other_personality ?> </li>
              <li><strong> OS:</strong> <?= $other_os ?></li>
          </ul>
      </div>
  </div>
<?php
            }
        }
    }
?>
</div>

<?php
if (count($matches) === 0) {
?>
<div> No match is found. </div>
<?php
}
include("bottom.html"); ?>
