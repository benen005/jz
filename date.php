	<div id="text0">日期选择：
	<?php 
	$this_year = date('Y');
	$this_month = date('m');
	$this_day = date('d')+1;
    //echo $this_day;
	for($i=1;$i<=$this_day;$i++){
		if($i < 10)
			$day = "0" . $i;
		else
			$day = $i;
		$this_date = $this_year . $this_month . $day;
        $show_date = (int)$this_month . "月" . $i . "日";
        if(date('Ymd') == $this_date)
            echo "<a href='?'>" . "<font color=red>今天</font>" . "</a> ";
        else
            echo "<a href='?date=$this_date'>" . $show_date . "</a> ";
	}

?>
	</div>