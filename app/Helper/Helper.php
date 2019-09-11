<?php

use Carbon\Carbon;

function base64_to_image($data, $path)
{
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);

    $up = File::put(public_path($path), $data);

    return $up;
}

function if_empty($str, $out = "-")
{
    if ($str == null) {
        return $out;
    }
    return $str;
}

function boolean_text($bool, $true = "aktif", $false = "tidak aktif")
{
    if ($bool == true) {
        return $true;
    } else {
        return $false;
    }
}

function text_to_boolean($text, $true = "aktif", $false = "tidak aktif")
{
    if ($text == $true) {
        return true;
    } else {
        return false;
    }
}

function getBulanFromDate($date, $year = false)
{
    $dt = Carbon::parse($date);
    if ($year) {
        return bulan($dt->month) . ' ' . $dt->year;
    }
    return bulan($dt->month);
}

function responseJson($message, $data = null, $status = true, $text = 'success', $statusCode = 200)
{
    return response(['status' => $status, 'text' => $text, 'message' => $message, 'data' => $data], $statusCode);
}

function bulan($month)
{
    if ($month == 1) {
        $bulan = 'januari';
    } else if ($month == 2) {
        $bulan = 'februari';
    } else if ($month == 3) {
        $bulan = 'maret';
    } else if ($month == 4) {
        $bulan = 'april';
    } else if ($month == 5) {
        $bulan = 'mei';
    } else if ($month == 6) {
        $bulan = 'juni';
    } else if ($month == 7) {
        $bulan = 'juli';
    } else if ($month == 8) {
        $bulan = 'agustus';
    } else if ($month == 9) {
        $bulan = 'september';
    } else if ($month == 10) {
        $bulan = 'oktober';
    } else if ($month == 11) {
        $bulan = 'november';
    } else if ($month == 12) {
        $bulan = 'desember';
    }

    return $bulan;
}

function waktu($timestamps)
{
    $dt = Carbon::parse($timestamps);
    return $dt->hour . ":" . $dt->minute;
}

function tanggal($timestamps, $separator)
{
    $dt = Carbon::parse($timestamps);

    return "{$dt->day}/{$dt->month}/$dt->year";
}

function tanggal_indo($timestamps, $tampilkan_hari = true, $tampilkan_waktu = true, $hanyaHari = false)
{
    $dt = Carbon::parse($timestamps);
    $hari = $dt->dayOfWeek;
    if ($hari == 1) {
        $hari = 'Senin';
    } else if ($hari == 2) {
        $hari = 'Selasa';
    } else if ($hari == 3) {
        $hari = 'Rabu';
    } else if ($hari == 4) {
        $hari = 'Kamis';
    } else if ($hari == 5) {
        $hari = 'Jumat';
    } else if ($hari == 6) {
        $hari = 'Sabtu';
    } else {
        $hari = 'Minggu';
    }

    if ($hanyaHari) {
        return $hari;
    }

    if ($tampilkan_hari == false) {
        $hari = "";
    }

    $day = $dt->day;
    $month = $dt->month;

    if ($month == 1) {
        $bulan = 'januari';
    } else if ($month == 2) {
        $bulan = 'februari';
    } else if ($month == 3) {
        $bulan = 'maret';
    } else if ($month == 4) {
        $bulan = 'april';
    } else if ($month == 5) {
        $bulan = 'mei';
    } else if ($month == 6) {
        $bulan = 'juni';
    } else if ($month == 7) {
        $bulan = 'juli';
    } else if ($month == 8) {
        $bulan = 'agustus';
    } else if ($month == 9) {
        $bulan = 'september';
    } else if ($month == 10) {
        $bulan = 'oktober';
    } else if ($month == 11) {
        $bulan = 'november';
    } else if ($month == 12) {
        $bulan = 'desember';
    }

    $bulan = ucwords($bulan);

    $tahun = $dt->year;

    $waktu = $dt->format("H:i:s");

    if ($tampilkan_waktu) {
        $tanggal = "$hari $day $bulan $tahun $waktu";
    } else {
        $tanggal = "$hari $day $bulan $tahun";
    }

    return $tanggal;
}

function buatToken($nikTps)
{
    $cipher = "idea-ofb";
    $iv = substr(hash('sha256', md5($nikTps)), 0, openssl_cipher_iv_length($cipher));
    $hasil = openssl_encrypt($nikTps, $cipher, md5("e-voting tabalong"), 0, $iv);

    return $hasil;
}

function generateToken()
{
    return mt_rand(100000, 999999);
}

function validateToken($token, $nikTps)
{
    $cipher = "idea-ofb";
    $iv = substr(hash('sha256', md5($nikTps)), 0, openssl_cipher_iv_length($cipher));
    $hasil = openssl_decrypt($token, $cipher, md5("e-voting tabalong"), 0, $iv);

    return $hasil == $nikTps;
}

function catzToken($nik, $periode)
{
    return md5(md5($nik . $periode));
}

function makeTanggal($date)
{
//    05|02|1987
    $explode = explode("|", $date);
    return "$explode[2]-$explode[1]-$explode[0]";
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

