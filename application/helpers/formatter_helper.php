<?php 

if(!defined('BASEPATH')) exit('No direct script access allowed');

function sensorNama($nama) {
    $nama_unsensored = substr($nama, 0, 3);
    $tobe_sensored = substr($nama, 3, strlen($nama) - 3);
    $sensored = preg_replace('/[^\s]/i', '*', $tobe_sensored);
    return $nama_unsensored.$sensored;
}
function sensorEmail($email) {
    $user_email = explode('@', $email)[0];
    $provider_email = explode('@', $email)[1];

    $user_email_unsensored = substr($user_email, 0, 3);
    $user_tobe_sensored = substr($user_email, 3, strlen($user_email) - 3);
    $user_sensored = preg_replace('/[^\.]/', '*', $user_tobe_sensored);
    $user_final = $user_email_unsensored.$user_sensored;

    $provider_email_unsensored = substr($provider_email, 0, 3);
    $provider_tobe_sensored = substr($provider_email, 3, strlen($provider_email) - 3);
    $provider_sensored = preg_replace('/[^\.]/', '*', $provider_tobe_sensored);
    $provider_final = $provider_email_unsensored.$provider_sensored;

    return $user_final.'@'.$provider_final;
}
?>