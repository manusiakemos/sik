<?php

use Carbon\Carbon;

function sendMessage($message="message",$id="like-button", $text="Like", $icon="https://sik.tabalongkab.go.id/images/tabalong.png", $url="https://sik.tabalongkab.go.id/#/home")
{
    $content = array(
        "en" => $message,
        "id" => $message,
    );
    $hashes_array = array();
    array_push($hashes_array, array(
        "id" => $id,
        "text" => $text,
        "icon" => $icon
    ));
    $fields = array(
        'app_id' => "31e318be-9285-4d18-b0c5-fc367f8dc8c4",
        'included_segments' => array(
            'All'
        ),
        "url" => $url,
//        'data' => array(
//            "foo" => "bar"
//        ),
        'contents' => $content,
        'web_buttons' => $hashes_array
    );

    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic N2QzYTYwOWQtNzUzOS00OGNkLWJiOTUtYTBhYjNlOThjMzY5'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

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

