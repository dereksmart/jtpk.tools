<?php

function calculate_median($arr) {
    $count = count($arr); //total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

$o = array();

// Total issues
$search = gh_request( 'https://api.github.com/search/issues', array( 'q' => 'repo:Automattic/jetpack is:open is:issue' ) );
$o['total_issues'] = $search->total_count;

// PRs in need of review
$search_ready_for_review = gh_request( 'https://api.github.com/search/issues', array( 'q' => 'repo:Automattic/jetpack is:open is:pr label:"[Status] Needs Review"' ) );
$o['prs_need_review'] = $search_ready_for_review->total_count;

$search = gh_request( 'https://api.github.com/search/issues', array( 'q' => 'repo:Automattic/jetpack is:open is:pr label:"[Status] Ready To Merge"' ) );
$o['prs_need_review'] += $search->total_count;

// Total PRs
$search = gh_request( 'https://api.github.com/search/issues', array( 'q' => 'repo:Automattic/jetpack is:open is:pr', 'per_page' => 100 ) );
$o['total_prs'] = $search->total_count;

$age = $ct = 0;
$ages = array();
// Average age of open PRs (total)
foreach ($search->items as $pr) {
	$this_age = ( time() - strtotime( $pr->created_at ) ) / 86400;
	$age += $this_age;
	$ages[] = $this_age;
	$ct++;
}

$o['average_age_in_days'] = floor( $age / $ct );
$o['median_age_in_days']  = floor( calculate_median( $ages ) );

// Average age of open PRs (ready for review)
// rfw = "ready_for_review"
$age_rfw = $ct_rfw = 0;
$ages_rfw = array();
foreach ($search_ready_for_review->items as $pr) {
    $this_age_rfw = ( time() - strtotime( $pr->created_at ) ) / 86400;
    $age_rfw += $this_age_rfw;
    $ages_rfw[] = $this_age_rfw;
    $ct_rfw++;
}
$o['average_review_age_in_days'] = floor( $age_rfw / $ct_rfw );
$o['median_review_age_in_days']  = floor( calculate_median( $ages_rfw ) );

foreach ($o as $key => $value) {
	$i = array(
		'meta_key' => $key,
		'value' => $value,
		'date' => date( 'Y-m-d' )
	);
	$wpdb->insert( 'gh_stats', $i );
}


//$wpdb->delete( 'gh_stats', array( 'date' => '2017-11-16' ) );
echo '<pre>';
print_r( $wpdb->get_results( 'SELECT * FROM gh_stats WHERE meta_key = "average_review_age_in_days" order by date ASC', OBJECT ) );
echo '</pre>';
