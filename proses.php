<?php
session_start();
require './db.php';
require_once 'CosineSimilarity.php';
$cmd = $_GET['cmd'];


switch ($cmd) {
	case 'cosine':
	    $keyword = $_POST['txtKeyword'];
	    $metode = $_POST['uMeotde'];

	    if($metode=='Cosine'){
	    	$rows = [];
	    	$sql = "SELECT tweet_clean FROM tweet";
       		$tweet_clean = mysqli_query($link, $sql);
			while($row = mysqli_fetch_array($tweet_clean))
			{
			    $rows = $row['tweet_clean'];
			    echo $rows."</br>";
			}
	    	$v1 = array('php' => 5, 'web' => 2,  'google' => 1);
			$v2 = array('php' => 0, 'web' => 5,  'google' => 10);

			$cs = new CosineSimilarity();

			$result1 = $cs->similarity($v1,$v2); // similarity of 1 and 2
			var_dump($result1); // #=> float(0.32659863237109)
	    	// echo "Cosine";
	    }
	    else if($metode=='Manhattan'){
	    	echo "Manhattan";
	    }
    break;

    default:
    	die("UNKNOWN");
    break;
}