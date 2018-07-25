<?php
echo '<pre>';

define( 'NEEDS_REVIEW', 199076921);
define( 'READY_TO_MERGE', 199076981);


$ghl = $wpdb->get_results( "SELECT * FROM github_log WHERE processed = 0 limit 300" );

foreach ( $ghl as $l_row )
{
	$l = json_decode($l_row->body);
	$i = array( 'when' => $l_row->time );

	$wpdb->update( 'github_log', array( 'processed' => 1 ), array( 'id' => $l_row->id ) );

	// It's a comment on a PR in need of review
	if( isset( $l->action ) && $l->action == 'created' && isset( $l->comment ) && isset( $l->issue->pull_request ) ) {
		$is_in_review = false;

		if( isset( $l->issue->labels ) ) {
			foreach( $l->issue->labels as $lab ) {
				if( $lab->id == NEEDS_REVIEW || $lab->id == READY_TO_MERGE ) {
					$is_in_review = true;
				}
			}
		}
		if ( ! $is_in_review ) {
			continue;
		}

		$i['who'] = $l->comment->user->login;
		$i['what'] = 'comment';
		$i['where'] = $l->issue->html_url;

		$wpdb->insert( 'gh_actions', $i );

		continue;
	}

	// It's a new PR
	if( isset( $l->action ) && $l->action == 'opened' && isset( $l->pull_request ) ) {
		$i['who'] = $l->sender->login;
		$i['what'] = 'new_pr';
		$i['when'] = date( 'Y-m-d H:i:s', strtotime( $l->pull_request->created_at ) );
		$i['where'] = $l->pull_request->html_url;
		$wpdb->insert( 'gh_actions', $i );

		continue;
	}

	// It's a PR getting a successful first review
	if( isset( $l->action ) && $l->action == 'labeled' && $l->label->id == READY_TO_MERGE && isset( $l->pull_request ) ) {
		$i['who'] = $l->sender->login;
		$i['what'] = 'review_passed';
		$i['when'] = date( 'Y-m-d H:i:s', strtotime( $l->pull_request->updated_at ) );
		$i['where'] = $l->pull_request->html_url;
		$wpdb->insert( 'gh_actions', $i );

		continue;
	}

	// It's a review being done
	if( isset( $l->review ) && $l->action == 'submitted' ) {
		$i['who'] = $l->sender->login;
		$i['what'] = 'review_passed';
		$i['when'] = date( 'Y-m-d H:i:s', strtotime( $l->pull_request->submitted_at ) );
		$i['where'] = $l->review->html_url;
		$wpdb->insert( 'gh_actions', $i );

		continue;
	}

	// It's a PR getting merged
	if( isset( $l->action ) && $l->action == 'closed' && isset( $l->pull_request ) && $l->pull_request->merged_at ) {
		$i['who'] = $l->sender->login;
		$i['what'] = 'merged';
		$i['when'] = date( 'Y-m-d H:i:s', strtotime( $l->pull_request->updated_at ) );
		$i['where'] = $l->pull_request->html_url;
		$wpdb->insert( 'gh_actions', $i );

		continue;
	}


	// It's an issue getting closed
	if( isset( $l->action ) && $l->action == 'closed' && isset( $l->issue ) ) {
		$i['who'] = $l->sender->login;
		$i['what'] = 'closed_issue';
		$i['where'] = $l->issue->html_url;
		$i['when'] = date( 'Y-m-d H:i:s', strtotime( $l->issue->updated_at ) );

		$wpdb->insert( 'gh_actions', $i );

		continue;
	}

}
