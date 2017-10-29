<?php
session_start();
require './db.php';
require_once 'CosineSimilarity.php';
$_SESSION['score']=array();
$cmd = $_GET['cmd'];


switch ($cmd) {
	case 'cosine':
		require './vendor/autoload.php';

		$sentence = $_POST['keyword'];

		$tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
		$tokenizer = $tokenizerFactory->createDefaultTokenizer();

		$tokens = $tokenizer->tokenize($sentence);

		$count = array_count_values($tokens);
		    

	    $keyword = $_POST['keyword'];
	    $metode = $_POST['uMeotde'];

	    if($metode=='Cosine'){
	    	$rows = [];
	    	$sql = "SELECT * FROM tweet";
       		$tweet_clean = mysqli_query($link, $sql);
			while($row = mysqli_fetch_array($tweet_clean))
			{
				$v1 = array();
				foreach (array_unique($tokens) as $key => $value) {
			    	/*$v1 = array_push($v1, );*/
			    	//echo $value." : ".$count[$value]."</br>";
			    	$v1[$value] = $count[$value];
				}
		    	$tokens1 = $tokenizer->tokenize($row['tweet_clean']);

				$count1 = array_count_values($tokens1);
				foreach (array_unique($tokens1) as $key => $values) {
			    	$v2[$values] = $count1[$values];
				}
			
				$cs = new CosineSimilarity();

				$result1 = $cs->similarity($v1,$v2);
				//echo $result1."</br>";

				$_SESSION['score'][$row['tweet_id']]=$result1;
	    	}
	    	arsort($_SESSION['score']);
	    	var_dump($_SESSION['score']);
	    }
	    else if($metode=='Manhattan'){
	    	echo "Manhattan";
	    }
				
    break;

    default:
    	die("UNKNOWN");
    break;
}