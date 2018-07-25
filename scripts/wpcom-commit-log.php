<?php

$payload_raw = $_GET['payload'];

$payload = json_decode( base64_decode( $payload_raw ) );

if( !is_object( $payload ) || !$payload->user ) {
	die( 'Invalid payload!' );
}

$i = array();
$i['user'] = $payload->user;
$i['pb'] = $payload->pb;
$i['files'] = $payload->files;
$i['pr'] = $payload->pr;
$i['reason'] = $payload->reason;

echo '<pre>';
print_r( $i );

$wpdb->insert( 'wpcom_commit_hook', $i );
