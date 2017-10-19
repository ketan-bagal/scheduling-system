<?php
include '../php_script/connectDB.php';

$time = array("08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00","19:00","20:00","21:00");
$timeLen = count($time);
$avRooms = array();
$rooms = array();
$programmeid=$_GET['programmeid'];
$campusid=$_GET['campusid'];
$startdate=$_GET['startdate'];
$enddate=$_GET['enddate'];
 $sql="SELECT classDuration FROM programme WHERE programmeid='".$programmeid."'";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
	$classDuration = $row['classDuration'];
}
  $sql = "SELECT room.* FROM room
	INNER JOIN building b ON room.buildingid = b.buildingid 
	INNER JOIN campus c ON b.campusid = c.campusid 
	WHERE c.campusid = '$campusid'";
// $ct=0;
 $result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($result)){
	$rooms[$row['roomid']]["name"] = $row['roomname'];
	$avRooms[$row['roomid']]["name"] = $row['roomname'];
	for($i=0; $i<$timeLen;$i++)
	{
		$rooms[$row['roomid']][$time[$i]] = "q";
	}
	
}   
$startTime;
$endTime;

 $sql="SELECT room.*,cohort.* FROM room
	INNER JOIN cohort ON cohort.roomid=room.roomid 
	WHERE EXISTS (SELECT s.semesterid FROM semester s WHERE s.cohortid=cohort.cohortid 
	AND ((s.startdate >='$startdate' AND s.startdate <='$enddate')
	OR (s.enddate >='$startdate' AND s.enddate <='$enddate')
	OR (s.startdate <='$startdate' AND s.enddate >= '$enddate')))
	AND EXISTS (SELECT b.buildingid FROM building b
	INNER JOIN campus c ON b.campusid = c.campusid
	WHERE room.buildingid = b.buildingid AND c.campusid = '$campusid')";
	
$result = mysqli_query($conn,$sql);
$tem = $timeLen-1;
if($result)
{
	if($result->num_rows ===0)
	{
		//do nothing
	}
	else
	{
		while($row = mysqli_fetch_array($result)){
			for($i=0; $i<$timeLen;$i++)
			{
				
				if($time[$i]>=substr((string)$row["starttime"],0,-3) && $time[$i]<substr((string)$row["endtime"],0,-3))
				{
					$rooms[$row['roomid']][$time[$i]] = "w";
				}
				
			}
		}		
	}
	
	$avTime;
$ct=0;
$count=0;
if(count($rooms)>0)
{
		foreach($rooms as $key=>$val){
			$ct=0;
			
			  for($i=0; $i<$timeLen;$i++)
			{
				if($rooms[$key][$time[$i]]=="q")
				{
					$ct++;
				}
				else if(($rooms[$key][$time[$i]] == "w")&& ($ct > 0 && $ct < $classDuration))
				{
					
						for($j=$i-$ct; $j <= $i; $j++)
						{
							$rooms[$key][$time[$j]] = "w";
						}
						
					
						
					$ct=0;
				}  
				else
				{
					$ct=0;
				}
				
				if(($i==$timeLen-1) && (($ct > 0) && ($ct < $classDuration)))
				{
					for($j=($i-$ct+1); $j <= $i; $j++)
						{
							$rooms[$key][$time[$j]] = "w";
						}
				}
				
				
			}

			  for($i=0; $i<$timeLen;$i++)
			{
				$count=0;
				if($rooms[$key][$time[$i]]=="q")
				{
					for($j=$i;$j<$i+$classDuration;$j++)
					{
						if($j<$timeLen)
						{
							if($rooms[$key][$time[$j]]=="q")
							{
								$count++;
							}
						}
						if($count==$classDuration)
						{
							$avTime = $time[$i]." - ".$time[$j];
						}
					}
				}
				
				if($count==$classDuration)
				{
						$avRooms[$key][$time[$i]]=$avTime;
				}
				
			}
				
			
				
			
		}
}
	
} 

echo json_encode($avRooms);

mysqli_close($conn);
?>