<?php 
/**
 * 配置文件
 */
 
//$ftp_url = "127.0.0.1:21:myweb:myweb";
$service_url = "http://127.0.0.1";
$ftp_url = array('127.0.0.1', '21', 'myweb', 'myweb');
$conn_array = array('localhost', 'root', '123456', 'jz');
$webname = "jz";
$website = "http://127.0.0.1/";

$cache_time = 180;

$image_info = array(
    'hash_layer'  => 2,
    'image_exts'  => array('jpg', 'gif', 'png'),
    'image_sizes' => array(
        'large'  => array(
            'default' => 'face_large.gif',
            'width'   => 800,
            'height'  => 800
        ),
        'small'  => array(
            'default' => 'face_small.gif',
            'width'   => 192,
            'height'  => 800
        ),
        'tiny'  => array(
            'default' => 'face_tiny.gif',
            'width'   => 57,
            'height'  => 57
        )
    )
);


?>
