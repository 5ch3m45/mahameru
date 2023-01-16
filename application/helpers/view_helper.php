<?php 

if(!defined('BASEPATH')) exit('No direct script access allowed');

function lampiranParser($lampirans)
{
    $html = '';
    if($lampirans) {
        foreach ($lampirans as $key => $lampiran) {
            if(in_array($lampiran['type'], ['image/jpeg', 'image/png'])) {
                $html .= '<img src="'.$lampiran['url'].'" class="avatars__img avatars__img-sm" />';
            } elseif(in_array($lampiran['type'], ['video/mp4'])) {
                $html .= '<img src="/assets/images/mp4.png" class="avatars__img avatars__img-sm" />';
            } elseif(in_array($lampiran['type'], ['application/pdf'])) {
                $html .= '<img src="/assets/images/pdf.png" class="avatars__img avatars__img-sm" />';
            } else {
                $html .= '<span class="avatars__others avatars__others-sm">+'.$lampiran['url'].'</span>';
            }
        }
    }

    return $html;
}

function statusParser ($status) {
    switch ($status) {
        case '1':
            return '<span class="badge bg-warning">Draft</span>';

        case '2':
            return '<span class="badge bg-success">Terpublikasi</span>';
            
        case '3':
            return '<span class="badge bg-danger text-light">Dihapus</span>';
    
        default:
            break;
    }
}