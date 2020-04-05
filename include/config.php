<?php 
/**
 * 配置文件
 */
 
//$ftp_url = "127.0.0.1:21:myweb:myweb";
$service_url = "http://127.0.0.1";
$ftp_url = array('127.0.0.1', '21', 'myweb', 'myweb');
$conn_array = array('localhost', 'root', '123456', 'jz');
$webname = "小ben成长手册";
$website = "http://benen005.gotoip1.com/";
$face_api_key = "7a7aec93e6e329e391f3665f615ec1ab";
$face_api_secret = "SdKw3BE-qZF-KvKmgn7dhQ3gzBGtMQTf";

/*七牛配置*/
$qiniu_accessKey = 'kD2zwRk_Pj5JGdNNiOgpfJzWhCgdts2Xtdu-Q0UI';
$qiniu_secretKey = '-OEdvokcixwYIjvrR6HdHZVXz7HMTergVPAzBk_I';
$qiniu_bucket = 'benen005';
$qiniu_flag = 1;//开启七牛图片
$qiniu_addr = "http://o8emplnez.bkt.clouddn.com/";

/* 本地图片 */
$pic_is_del = 1;//默认删除本地图片
$pic_local_addr = "upload_files/phone/";

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