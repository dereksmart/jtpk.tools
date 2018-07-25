<?php

$wpdb->insert( 'github_log', array( 'body' => stripslashes( $_POST['payload'] ) ) );

echo 'nom nom nom';
