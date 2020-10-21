<?php
  $r = $_SERVER['REQUEST_URI']; 
  $r = explode('=', $r);
  $myUsername = strstr($r[1], '&', true);
  $myPassword = strstr($r[2], '&', true);

  header('Content-type: text/plain');

  $myData = json_decode(file_get_contents("http://cdn.megaplay.xyz/panel_api.php?username=$myUsername&password=$myPassword"), true);
  
  $users=$myData['available_channels'];
  $categories=$myData['categories']['live'];

  if (isset($_GET['sort'])) {
    function compareByName($a, $b) {
    return strcmp($a["name"], $b["name"]);
    }
    usort($myData['available_channels'], 'compareByName');
  }

  if (isset($_GET['groups'])) {
  }
  else
  {
    echo "Please select at least 1 group";
    exit ();
  }

  $group=$_GET['groups'];
  $login=$_GET['login'];
  $password=$_GET['password'];

  foreach($myData['categories']['live'] as $key=>$val){
    $array[] = $val['category_name'];
  }

  foreach ($group as $value) {
    if (in_array($value, $array)) {
    }
    else {
      echo "The group ".$value." does not exist";
      exit();
    }
  }
ob_start();
  $clientportalurl= $myData['server_info']['url'] . $myData['server_info']['port'];
  echo "#EXTM3U";
  echo "\n";

  foreach ($group as $value) {
    foreach($myData['available_channels'] as $key=>$val){
      $cat_name2 = $val['category_name'];
      if ($cat_name2 == $value) {
        echo '#EXTINF:-1 tvg-id="'.$val['epg_channel_id'].'" tvg-name="'.$val['name'].'" tvg-logo="'.$val['stream_icon'].'" group-title="'.$val['category_name'].'",'.$val['name'].'';
        echo "\n";
        echo 'http://cdn.megaplay.xyz/live/'.$login.'/'.$password.'/'.$val['stream_id'].'.ts|User-agent=Neptune/1.1.3';
        echo "\n";
		  
      }
		$content = ob_get_contents();
		  $f = fopen("lista.txt", "w");
		  fwrite($f, $content);
fclose($f); 
    }
  }
?>