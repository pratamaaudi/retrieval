<?php
require './vendor/autoload.php';

$sentence = $_POST['keyword'];

$tokenizerFactory = new \Sastrawi\Tokenizer\TokenizerFactory();
$tokenizer = $tokenizerFactory->createDefaultTokenizer();

$tokens = $tokenizer->tokenize($sentence);

$count = array_count_values($tokens);
    
foreach (array_unique($tokens) as $key => $value) {
    echo $value." : ".$count[$value]."</br>";
}
?>