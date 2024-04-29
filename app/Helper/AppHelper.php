<?php

function standard_date_time_format($datetime) {

    return date('d-m-Y h:i A', strtotime($datetime));
}

function getImageUrl($image_name,$type='') {

    $url_scheme = '';
    $domain = '';

    $full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_scheme = parse_url($full_url, PHP_URL_SCHEME);

    $domain = request()->getHttpHost();

    //for local server
//    if($type == 'tracker'){
//        return $url_scheme.'://'.$domain.'/spearcom/public/assets/trackers/'.$image_name;
//    }else{
//        return $url_scheme.'://'.$domain.'/spearcom/public/assets/tracking_files/'.$image_name;
//    }

    if($type == 'parts'){
        return  $url_scheme.'://'.$domain.'/images/parts/'.$image_name;
    }elseif($type == 'ads'){
        return $url_scheme.'://'.$domain.'/ads/'.$image_name;
    }
    elseif($type == 'images')
    {
        return $url_scheme.'://'.$domain.'/images/profile-pic/'.$image_name;
    }
    elseif($type == 'payment')
    {
        return $url_scheme.'://'.$domain.'/assets/images/payment/'.$image_name;
    }
    elseif($type == 'manufacture')
    {
        return $url_scheme.'://'.$domain.'/images/manufacture/'.$image_name;
    }
    elseif($type == 'product-attachments')
    {
        return $url_scheme.'://'.$domain.'/public/product-attachments/'.$image_name;
    }
    elseif($type == 'chat-attachments')
    {
        return $url_scheme.'://'.$domain.'/public/images/chat/'.$image_name;
    }
    elseif($type == 'make')
    {
        return $url_scheme.'://'.$domain.'/assets/make/'.$image_name;
    }
    elseif($type == 'model')
    {
        return $url_scheme.'://'.$domain.'/images/settings/'.$image_name;
    }
    elseif($type == 'category')
    {
        return $url_scheme.'://'.$domain.'/assets/category/'.$image_name;
    }
    elseif($type == 'parts')
    {
        return $url_scheme.'://'.$domain.'/public/assets/parts/'.$image_name;
    }
    elseif($type == 'settings')
    {
        return $url_scheme.'://'.$domain.'/images/settings/'.$image_name;
    }
    elseif ($type == 'file')
    {
        return $url_scheme.'://'.$domain.'/'.$image_name;
    }
    elseif ($type == 'default-images')
    {
        return $url_scheme.'://'.$domain.'/images/defaultImages/'.$image_name;
    }
    else
    {
        return $url_scheme.'://'.$domain.'/assets/images/'.$image_name;
    }

}
//function url_and_domain()
//{
//    $url_scheme = '';
//    $domain = '';
//
//    $full_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//    $url_scheme = parse_url($full_url, PHP_URL_SCHEME);
//
//    $domain = request()->getHttpHost();
//    return [$url_scheme,$domain]
//}
