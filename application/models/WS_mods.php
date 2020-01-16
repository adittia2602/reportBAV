<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WS_mods extends CI_Model
{
    public function baseUrlApi() {
        $url = 'http://localhost:5000/';

        return $url;
    }

    public function fetchData( $method, $path, $data ) {
        $url = $this->baseUrlApi() . $path;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ( $method == "GET" ) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        }
        elseif ( $method == "POST" ) {
            $formdata = json_encode($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json" ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
        }

        $feedback = curl_exec($ch);
        curl_close($ch);

        $results = $feedback ? json_decode($feedback, true) : "Kesalahan koneksi Web Services.";

        return $results;
    }
}
