<?php

require_once ('/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/jpgraph/src/jpgraph.php');
require_once ('/home/dh_yt768n/jtpk.tools/wp-content/themes/jetstats/jpgraph/src/jpgraph_line.php');

$total_issues = $wpdb->get_results( 'SELECT * FROM gh_stats WHERE meta_key = "average_age_in_days" order by date ASC', OBJECT );

$max_y = 0;
foreach ($total_issues as $iss ) {
	$datax1[] = strtotime( $iss->date );
	$datay1[] = $iss->value;
	if( $iss->value > $max_y ) {
		$max_y = $iss->value;
	}
}

$total_issues = $wpdb->get_results( 'SELECT * FROM gh_stats WHERE meta_key = "median_age_in_days" order by date ASC', OBJECT );

foreach ($total_issues as $iss ) {
	$datax2[] = strtotime( $iss->date );
	$datay2[] = $iss->value;
	if( $iss->value > $max_y ) {
		$max_y = $iss->value;
	}
}


// The callback that converts timestamp to minutes and seconds
function TimeCallback($aVal) {
    return Date('Y-m-d',$aVal);
}



// Setup the basic graph
$graph = new Graph(800,600);
$graph->SetMargin(40,40,30,70);
$graph->title->Set('Average PR Age in Days (Mean and Median)');
$graph->SetAlphaBlending();

// Setup a manual x-scale (We leave the sentinels for the
// Y-axis at 0 which will then autoscale the Y-axis.)
// We could also use autoscaling for the x-axis but then it
// probably will start a little bit earlier than the first value
// to make the first value an even number as it sees the timestamp
// as an normal integer value.
$graph->SetScale("intlin",0,$max_y*1.05);

// Setup the x-axis with a format callback to convert the timestamp
// to a user readable time
$graph->xaxis->SetLabelFormatCallback('TimeCallback');
$graph->xaxis->SetLabelAngle(90);

// Create the line
$p1 = new LinePlot($datay1,$datax1);
$p1->SetColor('cornflowerblue');

// Add lineplot to the graph
$graph->Add($p1);

// Create the line
$p2 = new LinePlot($datay2,$datax2);
$p2->SetColor('chartreuse2');

// Set the fill color partly transparent
// $p1->SetFillColor("blue@0.4");


$graph->Add($p2);

// Output line
$graph->Stroke();
