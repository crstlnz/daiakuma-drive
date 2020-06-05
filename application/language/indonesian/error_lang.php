<?php



    $lang['fileNotFound'] = 'File tidak ditemukan.';

    $lang['fileNull'] = 'Gagal menyalin file.';

    $lang['unknownError'] = 'Telah terjadi Error. Code : ';

    $lang['noUrl'] = 'Masukkan URL!';

    $lang['wrongUrl'] = 'URL tidak valid!';

    $lang['driveFull'] = 'Drivemu penuh atau melebihi batas pemakaian, silahkan kosongkan dan coba lagi';

    $lang['deleted'] = "File telah di delete!";



    $lang['terpakai'] = 'Terpakai';

    $lang['dari'] = 'dari';

    $lang['halamantidakditemukan'] = "Maaf halaman tidak ditemukan.";


    function terpakai($used, $max){

        return "Terpakai ".$used." dari ".$max;

    }