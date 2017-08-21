<?php

$year=$_POST['csvyear'];
// output headers so that the file is downloaded rather than displayed
header('Content-type: text/csv');
header("Content-Disposition: attachment; filename=NZSE-".$year."schedule.csv");

// do not cache the file
header('Pragma: no-cache');
header('Expires: 0');

// create a file pointer connected to the output stream
$file = fopen('php://output', 'w');



include '../php_script/connectDB.php';
$result = "SELECT c.campusid, c.campusname FROM building b, room r, campus c, semester, cohort WHERE cohort.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid AND cohort.cohortid=semester.cohortid AND semester.startdate BETWEEN '".$year."-01-01' AND '".$year."-12-31' GROUP BY campusid";

if ($runquery = $conn->query($result))
{
  while($row = $runquery->fetch_assoc())
  {
    fputs($file, implode(array($row['campusname'], '', '', '', ''), ';')."\n");

    $result2 = "SELECT campus_programme.*, programme.name AS programmename, programme.semesters FROM campus_programme, programme, cohort WHERE  cohort.programmeid=programme.programmeid AND cohort.programmeid=campus_programme.programmeid AND campus_programme.campusid='".$row['campusid']."' GROUP BY programmeid";
    $runquery2 = $conn->query($result2);

    while($row2 = $runquery2->fetch_assoc())
    {
      fputs($file, implode(array($row2['programmename'], '', '', '', ''), ';')."\n");

    $result3 = "SELECT a.*,r.roomname, semester.startdate AS cohortstartdate, sub.enddate AS cohortenddate FROM building b, room r, campus c, cohort a, semester INNER JOIN (SELECT semester.enddate,semester.cohortid FROM semester, cohort WHERE cohort.cohortid = semester.cohortid AND semester.semestername='".$row2['semesters']."') sub ON sub.cohortid = semester.cohortid WHERE a.roomid=r.roomid AND b.buildingid=r.buildingid AND b.campusid=c.campusid AND semester.cohortid=a.cohortid AND semester.semestername='1' AND a.programmeid='".$row2['programmeid']."'";
      fputs($file, implode(array('', 'Start', 'End', 'Time', 'Room'), ';')."\n");


      $runquery3 = $conn->query($result3);
        while($row3 = $runquery3->fetch_assoc())
        {
          if ($year== date('Y', strtotime($row3['cohortstartdate']))) {

            fputs($file, implode(array($row3['cohortid'], date('d/m/Y', strtotime($row3['cohortstartdate'])), date('d/m/Y', strtotime($row3['cohortenddate'])), date('ha', strtotime($row3['starttime']))." - ".date('ha', strtotime($row3['endtime'])),  $row3['roomname']), ';')."\n");
          }
        }
    }
    fputs($file, implode(array('', '', '', '', ''), ';')."\n");
  }

}
fclose($file);



mysqli_close($conn);
exit();


 ?>
