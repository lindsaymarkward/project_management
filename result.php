<?php
session_name('main_site');
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: index.php");
} else {
	$sql = "SELECT * FROM users WHERE user_id=".$_SESSION['user'];
	$sth=$dbh->prepare($sql);
	$sth->execute();
	$userRow = $sth->fetchAll();
	$userRow = $userRow[0];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Results - <?php echo $userRow['user_email']; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>
<?php
include 'include\header.php';
?>


<div id="body">
	
	<h2><a href='index.php'>Home</a></h2>
	<a href='http://edwardsdean.net/jcu/limesurvey/index.php/764745?lang=en?UserID=<?php echo $_SESSION['user'] ?>'>Take Survey</a>
	
	<h2><a href='results.php'>My Results</a></h2>
	
	<?php
		$sql = "SELECT * FROM historic_survey_data WHERE historic_survey_data_id=".$_GET['survey_id']; 
		//print($sql);
		
		$sth=$dbh->prepare($sql);
		$sth->execute();
		$survey_info = $sth->fetchAll();
		$survey_info = $survey_info[0];
		
		//print_r($survey_info);
		
		?>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">
	$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Pedagogy of Difference'
        },
        subtitle: {
            text: 'Results form - <?php echo $survey_info['time_finished']; ?>'
        },
        xAxis: {
            categories: [
                'Indigenous Cultural Value',
                'Explicitness',
                'Self-regulation support',
                'Ethic of care',
                'Literacy teaching',
                'Behaviour support',
                'Pegagogical expertise'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Score'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Score',
            data: [<?php echo $survey_info['historic_survey_data_AVG_A']; ?>, <?php echo $survey_info['historic_survey_data_AVG_B']; ?>, <?php echo $survey_info['historic_survey_data_AVG_C']; ?>, <?php echo $survey_info['historic_survey_data_AVG_D']; ?>, <?php echo $survey_info['historic_survey_data_AVG_E']; ?>, <?php echo $survey_info['historic_survey_data_AVG_F']; ?>, <?php echo $survey_info['historic_survey_data_AVG_G']; ?>]

        }]
    });
});
		</script>
	
	
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	
</div>

</body>
</html>