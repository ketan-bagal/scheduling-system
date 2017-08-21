<?php
    include '../php_script/connectDB.php';
/*
    //Create Query
    	// get Year duration
    $queryYear = "SELECT MIN(semester.startdate) AS startdate, MAX(sub.enddate) AS enddate FROM semester, cohort, programme INNER JOIN (SELECT programme.level, semester.enddate FROM semester,cohort,programme WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid ='".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY endDate DESC) sub ON sub.level = programme.level WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid = '".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY startDate ASC";
		// get Level duration		
	$queryGetLevel = "SELECT programme.level AS level, programme.semesters AS semesters, semester.startdate, MAX(sub.enddate) AS enddate FROM semester, cohort, programme INNER JOIN (SELECT programme.level, semester.enddate FROM semester,cohort,programme WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid ='".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY endDate DESC) sub ON sub.level = programme.level WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid = '".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY programme.level ORDER BY startDate ASC";
    	// get Cohort
    $queryGetCohort = "SELECT semester.cohortid AS cohortid, semester.startdate AS startdate, sub.enddate AS enddate, programme.schoolid AS schoolid FROM cohort, programme, semester INNER JOIN (SELECT semester.cohortid, MAX(semester.enddate) AS enddate FROM cohort, semester WHERE cohort.cohortid = semester.cohortid AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY semester.cohortid) sub ON sub.cohortid = semester.cohortid WHERE programme.programmeid = cohort.programmeid AND cohort.cohortid = semester.cohortid AND programme.schoolid = '".$school."'  AND programme.level = '".$rowLevel['level']."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY semester.cohortid ORDER BY semester.startdate ASC";
    	// get Semester by cohortid
    $queryGetSemester = "SELECT cohort.cohortid AS cohortid, semester.semestername AS semester, semester.startdate AS startdate, semester.enddate AS enddate FROM semester, cohort WHERE cohort.cohortid = semester.cohortid AND cohort.cohortid = '".$rowCohort['cohortid']."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY semester ASC";
    	// get Courses by cohortid and semester
	$queryGetCourses = "SELECT programme_course.courseid AS courseid, course.duration AS duration, programme_course.priority AS priority FROM course, programme_course, cohort WHERE programme_course.programmeid = cohort.programmeid AND programme_course.courseid = course.courseid AND cohort.cohortid = '".$rowSemester['cohortid']."' AND programme_course.semester = '".$rowSemester['semester']."' ORDER BY programme_course.priority ASC, programme_course.semester ASC";
*/
	/*
		Structure
		Level{
			Cohort{
				Semester{
					Courses{

					}
				}

				termbreak{}
				Semester{}
				.
				.
				.
			}
		}

	*/
	// string - drawing schedule, name column, string2 - drawing bar graph

date_default_timezone_set('NZ');
$school = 2;
$startyear = date("Y");
$schoolname = "";
$percentage  = 100;
//Gantt Default controlled by schoolid on WHERE claus
$queryDefault = "SELECT * FROM school WHERE schoolid='2'";
$runDefault = mysqli_query($conn,$queryDefault);
while($rowDefault = mysqli_fetch_assoc($runDefault)){
	$school = $rowDefault['schoolid'];
	$schoolname = $rowDefault['name'];
}


if (isset($_POST['school'])&&isset($_POST['year'])) {
	$school=$_POST['school'];
	$startyear =$_POST['year'];
	$schoolname =$_POST[$school];
}

//    $today = date("Y-m-d", strtotime("2017-12-27"));
//    $percentage = 100;

	$string = '
{
    type: \'gantt\',
    renderAt: \'chart-container\',
    width: \'1000\',
    height: \'700\',
    dataFormat: \'json\',
    dataSource: {
        "chart": {
            "dateformat": "mm/dd/yyyy",
            "caption": "'.$startyear.' '.$schoolname.' Schedule",
            "showTaskLabels": "1",
            "slackFillColor": "#3A5FCD",
            "usePlotGradientColor": "0",
            "legendBorderAlpha": "0",
            "legendShadow": "0",
            "outputDateFormat": "dd mnl",
            "canvasBorderAlpha": "40",
            "ganttwidthpercent": "60",
            "ganttPaneDuration": "15",
            "usePlotGradientColor": "0",
            "showCanvasBorder": "0",
            "ganttPaneDurationUnit": "m",
            "taskBarFillMix": "light+0"
        },
        "categories": [{
            "category": [{';

    $string2 ='
        "tasks": {
            "task": [{';

        // Draw years for the schedule------------------------------------------
        
        $count = 0;
        for ($i=$startyear-1; $i <= $startyear+1; $i++) {
           	$startmonth = 1;
           	if($i==$startyear-1){
           		$startmonth = 8;
           	}
           	$endmonth = 12;
           	if($i==$startyear+1){
           		$endmonth = 5;
           	}

	        if($count == 0){
                $count++;
            }else{
                $string .= '
                    },{
                ';
            }
            $string .= '
                "start": "'.$startmonth.'/01/'.$i.'",
                "end": "'.$endmonth.'/31/'.$i.'",
                "label": "'.$i.'"
            ';
        }

        $string .= '
            }]
        }, {
            "category": [{';
        //Draw months for schedule----------------------------------------------------

        $count = 0;
        for ($year=$startyear-1; $year <= $startyear+1; $year++) {
           	$startmonth = 1;
           	if($year==$startyear-1){
           		$startmonth = 8;
           	}
           	$endmonth = 12;
           	if($year==$startyear+1){
           		$endmonth = 5;
           	}
            for ($month=$startmonth; $month <= $endmonth; $month++) {
                if($count == 1){
                    $string .='
                        "start": "0'.$month.'/01/'.$year.'",
                        "end": "0'.$month.'/31/'.$year.'",
                        "label": "'.$month.'/'.$year.'"
                    ';
                    $count++;
                }else{
                    $day=31;
                    if($month == 2){
                        $day=28;
                    }elseif ($month==4||$month==6||$month==9||$month==11) {
                        $day=30;
                    }
                    if($month <10){
                        $string .= '
                            },{
                            "start": "0'.$month.'/01/'.$year.'",
                            "end": "0'.$month.'/'.$day.'/'.$year.'",
                            "label": "'.$month.'/'.$year.'"
                        ';
                    }else{
                        $string .= '
                            },{
                            "start": "'.$month.'/01/'.$year.'",
                            "end": "'.$month.'/'.$day.'/'.$year.'",
                            "label": "'.$month.'/'.$year.'"
                        ';
                    }
                }
            }  // For month and days
        }// For year
        $string .='}]
            }],';

        $count = 0;
        //Draw Cohorts in 'Name column' -------------------------------------------- Start of contents.
        $string .= '
        "processes": {
            "fontsize": "12",
            "isbold": "1",
            "align": "center",
            "headerText": "'.$schoolname.'",
            "headerFontSize": "14",
            "headerVAlign": "center",
            "headerAlign": "center",
            "process": [{
            ';







       $queryYear = "SELECT MIN(semester.startdate) AS startdate, MAX(sub.enddate) AS enddate FROM semester, cohort, programme INNER JOIN (SELECT programme.level, semester.enddate FROM semester,cohort,programme WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid ='".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY endDate DESC) sub ON sub.level = programme.level WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid = '".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY startDate ASC";
       $runYear = mysqli_query($conn, $queryYear);
       while ($rowYear = mysqli_fetch_assoc($runYear)) {
           	
           	$string .= '
	            "label": "'.$startyear.'"
	        ';

	       	$string2 .= '
                "start": "'.$rowYear['startdate'].'",
                "color": "#000000",
                "end": "'.$rowYear['enddate'].'",
                "showAsGroup": "1",
                "label": "'.$startyear.'",
                "showLabel": "0"
          	';

            
       }

       // $queryGetLevel =  "SELECT programme.level AS level, programme.semesters AS semesters, semester.startdate, sub.enddate AS enddate FROM semester, cohort, programme INNER JOIN (SELECT programme.level, semester.enddate FROM semester,cohort,programme WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid ='".$school."' ORDER BY endDate DESC LIMIT 1) sub ON sub.level = programme.level WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND semester.semestername = '1' AND programme.schoolid = '".$school."' ORDER BY startDate ASC LIMIT 1";

       $queryGetLevel = "SELECT programme.level AS level, programme.semesters AS semesters, semester.startdate, MAX(sub.enddate) AS enddate FROM semester, cohort, programme INNER JOIN (SELECT programme.level, semester.enddate FROM semester,cohort,programme WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid ='".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY endDate DESC) sub ON sub.level = programme.level WHERE cohort.programmeid = programme.programmeid AND semester.cohortid = cohort.cohortid AND programme.schoolid = '".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY programme.level ORDER BY startDate ASC";
        $runLevel = mysqli_query($conn, $queryGetLevel);

	    if(!$runLevel){
	        die('Invalid query: level' . mysqli_error());
	    }
	    // While Level start.
        while($rowLevel = mysqli_fetch_assoc($runLevel)){
    		
	        $string .= '
	        			},{
	                        "label": "Level '.$rowLevel['level'].'"
	                ';
	            // Drawing bar for cohort
            $string2 .= '
            		},{
                    "start": "'.$rowLevel['startdate'].'",
                    "end": "'.$rowLevel['enddate'].'",
                    "showAsGroup": "1",
                    "label": "Level '.$rowLevel['level'].'",
                    "showLabel": "1"
            ';

			//$queryGetCohort = "SELECT semester.cohortid AS cohortid, semester.startdate AS startdate, sub.enddate AS enddate, programme.schoolid AS schoolid FROM cohort, programme, semester INNER JOIN (SELECT semester.cohortid, MAX(semester.enddate) AS enddate FROM cohort, semester WHERE cohort.cohortid = semester.cohortid AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY semester.cohortid) sub ON sub.cohortid = semester.cohortid WHERE programme.programmeid = cohort.programmeid AND cohort.cohortid = semester.cohortid AND programme.schoolid = '".$school."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY semester.cohortid ORDER BY semester.startdate ASC";
			$queryGetCohort = "SELECT semester.cohortid AS cohortid, semester.startdate AS startdate, sub.enddate AS enddate, programme.schoolid AS schoolid FROM cohort, programme, semester INNER JOIN (SELECT semester.cohortid, MAX(semester.enddate) AS enddate FROM cohort, semester WHERE cohort.cohortid = semester.cohortid AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY semester.cohortid) sub ON sub.cohortid = semester.cohortid WHERE programme.programmeid = cohort.programmeid AND cohort.cohortid = semester.cohortid AND programme.schoolid = '".$school."'  AND programme.level = '".$rowLevel['level']."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) GROUP BY semester.cohortid ORDER BY semester.startdate ASC";

		    $runCohort = mysqli_query($conn, $queryGetCohort);

	        if(!$runCohort){
	            die('Invalid query: cohort' . mysqli_error());
	        }

	        // While Cohort start
	        while($rowCohort = mysqli_fetch_assoc($runCohort)){
	            // Name Column of cohort
	            $string .= '
	                    }, {
	                        "label": "    '.$rowCohort['cohortid'].'"
	                ';
	            // Drawing bar for cohort
            	$string2 .= '
	            	},{
	                    "start": "'.$rowCohort['startdate'].'",
	                    "end": "'.$rowCohort['enddate'].'",
	                    "showAsGroup": "1",
	                    "label": "'.$rowCohort['cohortid'].'",
	                    "showLabel": "1"
	                ';

                $queryGetSemester = "SELECT cohort.cohortid AS cohortid, semester.semestername AS semester, semester.startdate AS startdate, semester.enddate AS enddate FROM semester, cohort WHERE cohort.cohortid = semester.cohortid AND cohort.cohortid = '".$rowCohort['cohortid']."' AND (semester.startdate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' OR semester.enddate BETWEEN '".$startyear."-01-01' AND '".$startyear."-12-31' ) ORDER BY semester ASC";

	            $runSemester = mysqli_query($conn, $queryGetSemester);

	            if(!$runSemester){
		            die('Invalid query: semester' . mysqli_error());
	            }
	            $termBreak = date("Y-m-d", strtotime($rowCohort['startdate']));

	            $count = 0;
	            // While Semester start
	            while($rowSemester = mysqli_fetch_assoc($runSemester)){
	            /*
	            	if($today<$rowSemester['startdate']){
	            		$percentage = 0;
	            	}elseif($today>$rowSemester['enddate']){
	            		$percentage = 100;
	            	}else{
	            		$total = intval((Trim($rowSemester['enddate'])-Trim($rowSemester['startdate'])) / 86400);
	            		$process =  intval((Trim($today)-Trim($rowSemester['startdate'])) / 86400);
	            		$res = $process/$total;
	            		$percentage = round($res*100);
	            	}
*/
	            	if($rowSemester['semester'] != 1 && $count != 0){
			        	$string .= '
			        	    }, {
		                        "label": "        Term Break"
			        		';
			        	$string2 .= '
		        		},{
		             		"start": "'.date("Y-m-d", strtotime($termBreak."+1 day")).'",
		                	"end": "'.date("Y-m-d", strtotime($rowSemester['startdate']."-1 day")).'",
		                	"color": "#1E90FF",
		                	"percentComplete": "'.$percentage.'"
			        	';

			        }
		        	$string .= '
		        		}, {
	                        "label": "        Semester '.$rowSemester['semester'].'"
		        		';
		        	$string2 .= '
		        		},{	
		             		"start": "'.$rowSemester['startdate'].'",
		                	"end": "'.$rowSemester['enddate'].'",
		                	"color": "#1E90FF",
		                	"label": "Semester'.$rowSemester['semester'].'",
		                	"percentComplete": "'.$percentage.'"
			        	';
			       	$count++;

			        $termBreak = date("Y-m-d", strtotime($rowSemester['enddate']));
			   
			    //    $queryGetCourses = "SELECT course.courseid AS courseid, course.duration AS duration, course.priority AS priority FROM course, cohort, semester WHERE course.programmeid = cohort.programmeid AND cohort.cohortid = semester.cohortid AND cohort.cohortid = '".$rowSemester['cohortid']."' AND course.semester = semester.semestername AND semester.semestername = '".$rowSemester['semester']."' ORDER BY course.priority ASC, course.semester ASC";
			        $queryGetCourses = "SELECT programme_course.courseid AS courseid, course.duration AS duration, programme_course.priority AS priority FROM course, programme_course, cohort WHERE programme_course.programmeid = cohort.programmeid AND programme_course.courseid = course.courseid AND cohort.cohortid = '".$rowSemester['cohortid']."' AND programme_course.semester = '".$rowSemester['semester']."' ORDER BY programme_course.priority ASC, programme_course.semester ASC";

		            $runCourses = mysqli_query($conn, $queryGetCourses);

			        if(!$runCourses){
			            die('Invalid query: courses' . mysqli_error());
			        }

			        $tempDate = date("Y-m-d", strtotime($rowSemester['startdate']));
			        //While Courses start
			        while($rowCourses = mysqli_fetch_assoc($runCourses)){


			        	$duration = $rowCourses['duration']*7 - 3;
			        	$startDate = $tempDate;
			        	$tempDate = date("Y-m-d", strtotime($startDate."+".$duration." day"));

/*			        	if($today<$startDate){
		            		$percentage = 0;
		            	}elseif($today>$tempDate){
		            		$percentage = 100;
		            	}else{

		            		$total = intval((Trim($tempDate)-Trim($startDate)) / 86400);
		            		$process = intval((Trim($today)-Trim($startDate)) / 86400);
		            		$res = $process/$total;
		            		$percentage = round($res * 100);
		            	}
*/

			        	$string .= '
			        	    }, {
		                        "label": "            '.$rowCourses['courseid'].'"
			        	';
			        	$string2 .= '
				        	},{
			             		"start": "'.$startDate.'",
			                	"end": "'.$tempDate.'",
			                	"color": "#1E90FF",
		              		  	"percentComplete": "'.$percentage.'"
			        		';
			        	$tempDate = date("Y-m-d", strtotime($tempDate."+3 day"));
			        } //while courses

	            }	// while semester

	        }   //while cohort
        }	//while level
        $string .= '
            }]
        },
        ';

        $string2 .= '
            }]
        },
        "trendlines": [{
            "line": [
        '; //end of tasks
        for ($i=$year; $i<$startyear+1 ; $i++) {
        	# code...
        }
        $string2 .= '
        	{
                "start": "12/25/'.($startyear-1).'",
                "end": "01/07/'.$startyear.'",
                "displayvalue": "Christmas Week",
                "istrendzone": "1",
                "alpha": "20",
                "color": "#F16A73"
            },{
                "start": "12/25/'.$startyear.'",
                "end": "01/07/'.($startyear+1).'",
                "displayvalue": "Christmas Week",
                "istrendzone": "1",
                "alpha": "20",
                "color": "#F16A73"
            }
        ';



        $string2 .= '
        		]
        }]
    }
}
            ';
        $string .= $string2;
?>

<html>
<head>
<title>My first chart using FusionCharts Suite XT</title>
<script type="text/javascript" src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
<script type="text/javascript" src="http://static.fusioncharts.com/code/latest/themes/fusioncharts.theme.fint.js?cacheBust=56"></script>
<script type="text/javascript">
  FusionCharts.ready(function(){
    var fusioncharts = new FusionCharts(<?php echo $string;?>);
    fusioncharts.render();
});
</script>
</head>
<body>
	<?php
	$strSearch = "	<form id='' action='".$_SERVER['PHP_SELF']."' method='post'>
						<label for='school'>School:</label>
						<select name='school'>";
	$strSearch2 = "";
	$queryGetSearch= "SELECT * FROM school ORDER BY school.schoolid ASC";
	$runGetSearch = mysqli_query($conn, $queryGetSearch);
	if(!$runGetSearch){
	    die('Invalid query:Search ' . mysqli_error());
	}

	$count = 0;
	while($rowSearch = mysqli_fetch_assoc($runGetSearch)){
		$strSearch.= "	<option value='".$rowSearch['schoolid']."'>".$rowSearch['name']."</option>";
		$strSearch2.= "<input type='hidden' name='".$rowSearch['schoolid']."' value='".$rowSearch['name']."'>";
	}
	$strSearch .="		</select>
						<input type='number' name='year' value='".$startyear."'>";

	$strSearch2 .="		<input type='submit' name='submit' value='View'>
					</form>";
	$strSearch .= $strSearch2;
	echo $strSearch;



	mysqli_close($conn);
	?>

  <div id="chart-container">FusionCharts XT will load here!</div>
</body>
</html>
