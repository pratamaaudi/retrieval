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

		$v2 = array();
	    $v1 = array();

		foreach (array_unique($tokens) as $key => $value) {
			    	/*$v1 = array_push($v1, );*/
			    	//echo $value." : ".$count[$value]."</br>";
			    	$v1[$value] = $count[$value];
				}
		    

	    $keyword = $_POST['keyword'];
	    $metode = $_POST['uMeotde'];

	    
	    $count1;

	    if($metode=='Cosine'){
			$query = "SELECT * FROM tweet WHERE tweet_clean like '%".array_keys($v1)[0]."%'";	
			foreach ($v1 as $key => $value) {
				$query .= ' or "%'.$key.'%"';
			}

	    	$rows = [];
	    	$sql = "SELECT * FROM tweet WHERE tweet_clean like '%".$keyword."%'";
       		$tweet_clean = mysqli_query($link, $query);
			while($row = mysqli_fetch_array($tweet_clean))
			{
				
		    	$tokens1 = $tokenizer->tokenize($row['tweet_clean']);
				$count1 = array_count_values($tokens1);

				//foreach (array_unique($tokens1) as $key => $values) {
			    //	$v2[$values] = $count1[$values];
				//}

				foreach ($v1 as $key => $values) {
			    	if(isset($count1[$key])){
			    		$v2[$key] = $count1[$key];
			    	} else {
			    		$v2[$key] = 0;
			    	}
				}
			
				$cs = new CosineSimilarity();

				$result1 = $cs->similarity($v2,$v1);
				//echo $result1."</br>";

				$_SESSION['score'][$row['tweet_id']]=$result1;
	    	}
	    	arsort($_SESSION['score']);
	    	var_dump($_SESSION['score']);
	    }
	    else if($metode=='Manhattan'){
	    	echo "Manhattan";

$query = "SELECT * FROM tweet WHERE tweet_clean like '%".array_keys($v1)[0]."%'";	
			foreach ($v1 as $key => $value) {
				$query .= ' or "%'.$key.'%"';
			}

	    	$rows = [];
	    	$sql = "SELECT * FROM tweet WHERE tweet_clean like '%".$keyword."%'";
       		$tweet_clean = mysqli_query($link, $query);
			while($row = mysqli_fetch_array($tweet_clean))
			{
				
		    	$tokens1 = $tokenizer->tokenize($row['tweet_clean']);
				$count1 = array_count_values($tokens1);

				//foreach (array_unique($tokens1) as $key => $values) {
			    //	$v2[$values] = $count1[$values];
				//}

				foreach ($v1 as $key => $values) {
			    	if(isset($count1[$key])){
			    		$v2[$key] = $count1[$key];
			    	} else {
			    		$v2[$key] = 0;
			    	}
				}


				//var_dump($v1);
				//var_dump($v2);
				
				$hasil = distance($v1,$v2);
				// echo $hasil."</br>";

				$_SESSION['score'][$row['tweet_id']]=$hasil;
	    	}
	    	arsort($_SESSION['score']);
	    }
				
    break;

    default:
    	die("UNKNOWN");
    break;


}



function distance($vector1, $vector2)
    {
        $n = count($vector1);
        $sum = 0;
        foreach ($vector1 as $key => $value) {
        	$sum += abs($vector1[$key] - $vector2[$key]);
        }

        //for ($i = 0; $i < $n; $i++) {
           // $sum += abs($vector1[$i] - $vector2[$i]);
       // }
        return $sum;
    } 

 header('Location:index.php');