<?php

$debug = true;
require 'db.php';
require './vendor/autoload.php';
$query = "SELECT * FROM tweet";
$result = mysqli_query($link, $query);
$tweet_clean = array();

while ($row = mysqli_fetch_array($result)) {
  $tweet_clean[$row['tweet_id']] = $row['tweet_clean'];
}

if (isset($debug)) {
  echo 'isi $tweet_clean : </br>';
  ?><pre><?php
  print_r($tweet_clean);
  ?></pre><?php
  echo '<br>';
}

$arrayKata = array();
$tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
$tokenizer = $tokenizerFactory->createDefaultTokenizer();
foreach ($tweet_clean as $key => $value) {
  $tokens = $tokenizer->tokenize($value);
  if (isset($debug)) {
    echo '<br> tokenize dokumen ' . $key . ' : ';
    foreach ($tokens as $key => $value2) {
      echo ' ' . $value2 . ' ';
    }
    echo '</br>';
  }
  foreach ($tokens as $key => $value2) {
    if (isset($arrayKata[$value2])) {
      if (isset($debug)) {
        echo '<br> ada kata ' . $value2 . ' sebanyak ' . $arrayKata[$value2] . ' di array kata <br>';
      }
      $arrayKata[$value2] ++;
    } else {
      if (isset($debug)) {
        echo '<br> tidak ada kata ' . $value2 . ' di array kata <br>';
      }
      $arrayKata[$value2] = 1;
    }
  }
} 




ksort($arrayKata);
if (isset($debug)) {
  echo '<br> kamus kata : <br>';
  ?><pre><?php
  print_r($arrayKata);
  ?></pre><?php
}



$arrayTabelData = array();
foreach ($arrayKata as $key => $value) {
/*echo '<br>' . $key . '<br>';*/
  $arrayTabelData[$key] = array();
  foreach ($tweet_clean as $key2 => $value2) {
$arrayTabelData[$key][$key2] = 0;
/*echo '<br>' . $value2 . '<br>';*/
    $tokens = $tokenizer->tokenize($value2);
    foreach ($tokens as $key3 => $value3) {
      if ($key == $value3) {
        if (isset($arrayTabelData[$key][$key2])) {
          $arrayTabelData[$key][$key2] ++;
        } else {
          $arrayTabelData[$key][$key2] = 1;
        }
      } else {
        $arrayTabelData[$key][$key2] = 0;
      }
    }
  }
}





$arrayHitungKata = array();
foreach ($arrayKata as $key => $value) {
  echo '</br> jumlah kata '.$key. count($arrayTabelData[$key])."</br>";
  $arrayHitungKata[$key]= count($arrayTabelData[$key]);
}
if (isset($debug)) {
  echo '<br> isi $arrayTabelData : <br>';
  ?><pre><?php
  print_r($arrayTabelData);
  ?></pre><?php
} 





$count = "SELECT COUNT(tweet_id) as FG FROM tweet";
$res = mysqli_query($link, $count);
$totalDoc;

while ($row = mysqli_fetch_array($res)) {
  $totalDoc = $row['FG'];
}

$N = null;
$query = "SELECT kata, COUNT(idTweet) as totalTweet, jumlah FROM `tabel_tahap1` GROUP BY kata ORDER BY totalTweet Desc limit 1";
$result = mysqli_query($link2, $query);
while ($row = mysqli_fetch_array($result)) {
  $N = $row['totalTweet'];
}

$raw = "SELECT kata, COUNT(idTweet) as totalTweet, jumlah FROM `tabel_tahap1` GROUP BY kata";
$res2 = mysqli_query($link2, $raw);
$tfRaw;
while ($row = mysqli_fetch_array($res2)) {
  $tfRaw = $row['jumlah'];
  echo "</br> Total Doc : ".$totalDoc.'</br>';
  echo "</br> TF Raw : ".$tfRaw. '</br>';
  echo "</br> DFT : ".$arrayHitungKata[$row['kata']]. '</br>';
  $tfidf = $tfRaw * log( $totalDoc / $row['totalTweet']);

  $idf = log($N / $row['totalTweet']);
  $kata = $row['kata'];

//    $sql = "INSERT INTO idf (nama, idf) VALUES ('$kata','$idf')";
//    $result = mysqli_query($link3, $sql);
//    if (!$result) {
//        echo $sql;
//    }
// echo "</br> TFIDF ". $row['kata'].' '.$tfidf.' </br>';
}

$count = "SELECT * FROM idf tf INNER JOIN tabel_tahap1 th on tf.nama = th.kata";
$resti = mysqli_query($link2, $count);
$tfidf;
while ($row = mysqli_fetch_array($resti)) {
  $kata = $row['kata'];
  $id = $row['idTweet'];
  $tfidf = $row['jumlah'] * $row['idf'];
  $sql = "INSERT INTO tfidf (kata,id, jumlah) VALUES ('$kata','$id','$tfidf')";
  $result = mysqli_query($link3, $sql);
  if (!$result) {
    echo $sql;
  }
}

if ($debug) {
//    echo 'total doc : '.$totalDoc.'<br>';
//    echo 'nilai N : '.$N.'<br>';
}
?>