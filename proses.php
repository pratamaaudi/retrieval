<?php

session_start();
require './db.php';
require_once 'CosineSimilarity.php';
require_once './cosineaudi.php';
$_SESSION['score'] = array();
$cmd = $_GET['cmd'];
unset($_SESSION['score']);


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
            /* $v1 = array_push($v1, ); */
            //echo $value." : ".$count[$value]."</br>";
            $v1[$value] = $count[$value];
        }

        $keyword = $_POST['keyword'];
        $metode = $_POST['uMeotde'];

        $count1;

        /* Cosine Start */
        if ($metode == 'Cosine') {
            $query = "SELECT tweet_id FROM tweet";

            $rows = [];
            $tweet_clean = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($tweet_clean)) {
                foreach ($v1 as $key => $values) {
                    $query2 = "select * from tfidf WHERE kata='" . $key . "' AND id=" . $row['tweet_id'];
                    echo $query2;
                    $queryHasilV2 = mysqli_query($link2, $query2);
                    $v2[$key] = 0;
                    while ($row2 = mysqli_fetch_array($queryHasilV2)) {
                        $v2[$key] = (double) $row2['jumlah'];
                    }
                    echo "double " . $v2[$key] . "</br>";
                }

                $tmp = array_filter($v2);
                echo 'empty : ' . empty($tmp) . '<br>';
                if (empty($tmp)) {
                    $_SESSION['score'][$row['tweet_id']] = 0;
                } else {

                    $result1 = similarity($v1, $v2);

                    $_SESSION['score'][$row['tweet_id']] = $result1;
                }
                echo $_SESSION['score'][$row['tweet_id']] . '</br>';
            }
            arsort($_SESSION['score']);
            echo "<pre>";

            var_dump($_SESSION['score']);
            echo "</pre>";
        }

        /* Manhattan Start */ else if ($metode == 'Manhattan') {

            //echo "Manhattan";
            //$query = "SELECT * FROM tweet WHERE tweet_clean like '%".array_keys($v1)[0]."%'";	
            //foreach ($v1 as $key => $value) {
            //$query .= ' or "%'.$key.'%"';
            //}	
            $query = "SELECT tweet_id FROM tweet";

            $rows = [];
            //$sql = "SELECT * FROM tweet WHERE tweet_clean like '%".$keyword."%'";
            $tweet_clean = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($tweet_clean)) {
                //echo 'aaaa <br>';
                //$tokens1 = $tokenizer->tokenize($row['tweet_clean']);
                // $count1 = array_count_values($tokens1);
                //foreach (array_unique($tokens1) as $key => $values) {
                //$v2[$values] = $count1[$values];
                //}

                foreach ($v1 as $key => $values) {
                    $query2 = "select * from tfidf WHERE kata='" . $key . "' AND id=" . $row['tweet_id'];
                    
                    echo $key;
                    $queryHasilV2 = mysqli_query($link2, $query2);
                    $v2[$key] = 0;
                    while ($row2 = mysqli_fetch_array($queryHasilV2)) {
                        $v2[$key] = $row2['jumlah'];
                    }
                    echo $v2[$key];
                }

                //var_dump($v1);
                //var_dump($v2);

                $hasil = distance($v1, $v2);
                // echo $hasil."</br>";

                $_SESSION['score'][$row['tweet_id']] = $hasil;
            }
            asort($_SESSION['score']);
        }
        /* Manhattan End */
        break;

    default:
        die("UNKNOWN");
        break;
}
header('Location:index.php');

function distance($vector1, $vector2) {
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

echo '<script type="text/javascript">
           window.location = "index.php"
      </script>';
