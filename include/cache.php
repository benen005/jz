<?php 
$cache = new cache('../cache/1');
$data = file_get_contents("http://127.0.0.1/ben/index.php");
echo $cache->readData('index.php', $data);


//echo "<br />";
//echo $cache->get_url();

class cache { 
/* 
Class Name: cache 
Description: control to cache data,$cache_out_time is a array to save cache date time out. 
*/ 

private $cache_dir; 
private $expireTime=180;//缓存的时间是 60 秒 

function __construct($cache_dirname)
{ 
	if(!@is_dir($cache_dirname))
	{ 
		if(!@mkdir($cache_dirname,0777))
		{ 
			$this->warn('缓存文件不存在而且不能创建,需要手动创建.'); 
			return false; 
		} 
	} 
	$this->cache_dir = $cache_dirname; 
}

function __destruct()
{ 
	echo 'Cache class bye.'; 
} 

function get_url() 
{ 
	if (!isset($_SERVER['REQUEST_URI'])) 
	{ 
		$url = $_SERVER['REQUEST_URI']; 
	}
	else
	{ 
		$url = $_SERVER['SCRIPT_NAME']; 
		$url .= (!empty($_SERVER['QUERY_STRING'])) ? '?' . $_SERVER['QUERY_STRING'] : ''; 
	} 

	return $url; 
} 

function warns($errorstring)   //已用
{ 
	echo "发生错误:
	".$errorstring."
	"; 
} 

function cache_page($pageurl,$pagedata)  //已用
{ 
	if(!$fso=fopen($pageurl,'w'))
	{ 
		$this->warns('无法打开缓存文件.');//trigger_error 
		return false; 
	} 
	
	if(!flock($fso,LOCK_EX))
	{
		//LOCK_NB,排它型锁定 
		$this->warns('无法锁定缓存文件.');
		//trigger_error 
		return false; 
	} 
	
	if(!fwrite($fso,$pagedata))
	{
		//写入字节流,serialize写入其他格式 
		$this->warns('无法写入缓存文件.');
		//trigger_error 
		return false; 
	} 
	flock($fso,LOCK_UN);//释放锁定 
	fclose($fso); 
	return true; 
} 

function display_cache($cacheFile)  //已用
{ 
	if(!file_exists($cacheFile))
	{ 
		$this->warn('无法读取缓存文件.');//trigger_error 
		return false; 
	} 
	//echo '读取缓存文件:'.$cacheFile; 
	//return unserialize(file_get_contents($cacheFile)); 
	$fso = fopen($cacheFile, 'r'); 
	$data = fread($fso, filesize($cacheFile)); 
	fclose($fso); 
	return $data; 
} 

function readData($cacheFile='default_cache.txt', $data)
{ 
	$cacheFile = $this->cache_dir."/".$cacheFile; 
	if(file_exists($cacheFile)&&filemtime($cacheFile)>(time()-$this->expireTime))
	{ 
		$data=$this->display_cache($cacheFile); 
	}
	else
	{ 
		//$data="data"; 
		$this->cache_page($cacheFile,$data); 
	} 
	return $data; 
} 

} 
?> 