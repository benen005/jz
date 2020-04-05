<?php
/*
	智汀网络开发 http://www.go0663.cn
	作者：R
	邮箱：go522000@126.com
*/
class db_page
{
	private $conn;
	private $page;
	private $page_all;
	
	function __construst($conn)		//PHP5
	{
		$this->db_page($conn);
	}
	function db_page($conn)		//PHP4
	{
		if($conn){
			$this->conn = $conn;
			return true;
		}else{
			die("PAGE: NOT MYSQL");
		}
	}
	
	function db_query($sql,$by='',$page=0,$number=20)
	{
		$result = $this->conn->db_query($sql);
		$max = $this->conn->db_num($result);
		$page_all = ceil($max/$number);
		if($page > $page_all) $page=$page_all;
		if($page == "" || $page == 0) $page = 1;
		$this->page = $page;
		$page = ($page-1)*$number;
		if(!empty($by)) $sql .= " ORDER BY ".$by;
		$sql .= " LIMIT $page,$number";
		$result = $this->conn->db_query($sql);
		$this->page_all = $page_all;
		return $result;
	}
	function db_next($get='')
	{
		global $zj_lang;
		$next = "";
		if($this->page <= 1){
			$next .= $zj_lang['index']['up'];
		}else{
			if(empty($get)){
				$next .= '<a href="?page='.($this->page-1).'">'.$zj_lang['index']['up'].'</a>';
			}else{
				$next .= '<a href="?'.$get.'&page='.($this->page-1).'">'.$zj_lang['index']['up'].'</a>';
			}
		}
		$next .= " ".$this->page."/".$this->page_all." ";
		if($this->page >= $this->page_all){
			$next .= $zj_lang['index']['down'];
		}else{
			if(empty($get)){
				$next .= '<a href="?page='.($this->page+1).'">'.$zj_lang['index']['down'].'</a>';
			}else{
				$next .= '<a href="?'.$get.'&page='.($this->page+1).'">'.$zj_lang['index']['down'].'</a>';
			}
		}
		return $next;
	}
}
?>