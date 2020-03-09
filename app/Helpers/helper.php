<?php 


function convert_sql_date($date){
	return Carbon\Carbon::createFromFormat('m/d/Y', $date)->toDateString();
}

function convertToHoursMins($time, $format = '%02d:%02d:%02d') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    $second = ($minutes) * 60 / 60;
    return sprintf($format, $hours, $minutes, $second);
}


function calculateWorkingDaysInMonth($year = '', $month = '')
{
	//in case no values are passed to the function, use the current month and year
	if ($year == '')
	{
		$year = date('Y');
	}
	if ($month == '')
	{
		$month = date('m');
	}	
	//create a start and an end datetime value based on the input year 
	$startdate = strtotime($year . '-' . $month . '-01');
	$enddate = strtotime('+' . (date('t',$startdate) - 1). ' days',$startdate);
	$currentdate = $startdate;
	//get the total number of days in the month	
	$return = intval((date('t',$startdate)),10);
	//loop through the dates, from the start date to the end date
	while ($currentdate <= $enddate)
	{
		//(date('D',$currentdate) == 'Sat') || 
		//if you encounter a Saturday or Sunday, remove from the total days count
		if ((date('D',$currentdate) == 'Sun'))
		{
			$return = $return - 1;
		}
		$currentdate = strtotime('+1 day', $currentdate);
	} //end date walk loop
	//return the number of working days
	return $return;
}
