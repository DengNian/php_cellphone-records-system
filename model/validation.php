<?php

//refer :https://www.jianshu.com/p/d3770dc43f79
function dateBDate($date1, $date2) {
	// date1 bigger than date2
	 $month1 = date("m", strtotime($date1));
	 $month2 = date("m", strtotime($date2));
	 $day1 = date("d", strtotime($date1));
	 $day2 = date("d", strtotime($date2));
	 $year1 = date("Y", strtotime($date1));
	 $year2 = date("Y", strtotime($date2));
	 $from = mktime(0, 0, 0, $month1, $day1, $year1);
	 $to = mktime(0, 0, 0, $month2, $day2, $year2);
	 if ($from > $to) {
		return true;
	 } else {
		return false;
	 } 
} 