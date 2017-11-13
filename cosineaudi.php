<?php

function cosine($arrayQuery, $arrayDokumen) {
    //hasil disiapkan sebagai return
    $hasil = 0;

    //penyebut untuk menampung value pembagian
    $penyebut = 0;

    //pembilang untuk menampung value pembagian
    $pembilang = 0;

    //hitung penyebut
    //setiap item di array query (inputan user)
    foreach ($arrayQuery as $key => $valueQuery) {

        //tampung isi dari array 2 dengan kata yang sama ke dalam value dokumen
        $valueDokumen = $arrayDokumen[$key];

        //isi penyebut ditambakan dengan hasil perkalian bobotquery dan bobotdokumen untuk setiap kata
        $penyebut += ($valueQuery * $valueDokumen);
    }

    //totalbobotquery guna menampung total dari isi arrayquery
    $totalBobotQuery = 0;

    //totalbobotdokumen guna menampung total dari isi arraydokumen
    $totalBobotDokumen = 0;

    //setiap arrayquery
    foreach ($arrayQuery as $key => $value) {

        //totalbobotquery dijumlahkan dengan isi arrayquery kuadrat
        $totalBobotQuery += ($value * $value);
    }

    //setiap arraydokumen
    foreach ($arrayDokumen as $key => $value) {

        //totalBobotDokumen dijumlahkan dengan isi arrayDokumen kuadrat
        $totalBobotDokumen += ($value * $value);
    }

    //mengisi pembilang dengan hasil perkalian bobot dokumen dan query
    $pembilang = ($totalBobotDokumen * $totalBobotQuery);

    //jika pembilang tidak 0
    if (!$pembilang == 0) {
        
        //ubah hasil sesuai penyebut dibagi pembilang
        $hasil = $penyebut / $pembilang;
    }

    //kembalikan varabel hasil
    return $hasil;
}
?>