<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Jetstats
 */

get_header();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				$last = array();
				$last['day'] = $wpdb->get_results('select who, count(id) as count, what from gh_actions where `when` > "' . date( 'Y-m-d H:i:s', strtotime('24 hours ago') ) . '" group by who, what;');
				$last['week'] = $wpdb->get_results('select who, count(id) as count, what from gh_actions where `when` > "' . date( 'Y-m-d H:i:s', strtotime('7 days ago') ) . '" group by who, what;');
				$last['month'] = $wpdb->get_results('select who, count(id) as count, what from gh_actions where `when` > "' . date( 'Y-m-d H:i:s', strtotime('1 month ago') ) . '" group by who, what;');

				function sort_jpgh_stats( $stats ) {
					$peeps = array();

					$team_members = array(
						'samhotchkiss',
						'dereksmart',
						'thingalon',
						'zinigor',
						'jeherve',
						'rcoll',
						'georgestephanis',
						'singerb',
						'briancolinger',
						'eliorivero'
					);

					foreach ($stats as $stat) {

						if( in_array( $stat->who, $team_members ) ) {
							$display = "<strong>" . $stat->who . '</strong>';
						} else {
							$display = $stat->who;
						}

						if( !isset( $peeps[ $stat->who ] ) ) {
							$peeps[ $stat->who ]= array(
								'display' => $display,
								'name' => $stat->who,
								'closed_issue' => 0,
								'comment' => 0,
								'review_passed' => 0,
								'new_pr' => 0,
								'merged' => 0,
								'points' => 0,
							);
						}
						$peeps[ $stat->who ][ $stat->what ] = $stat->count;
						$peeps[ $stat->who ]['points'] += $stat->count;
					}

					usort($peeps, function($a, $b) {
    						return $b['points'] - $a['points'];
					});

					return $peeps;
				}

			?>

			<?php foreach ($last as $period => $l): ?>
				<h1>In the last <?php echo $period ?>...</h1>
				<?php if ( $l ):
					$peeps = sort_jpgh_stats( $l );

					?>
					<table>
						<tr>
							<th>&nbsp;</th>
							<th>User</th>
							<th>Issues Closed</th>
							<th>Comments</th>
							<th>Review Completed</th>
							<th>PR Merged</th>
							<th>PR Created</th>
							<th>Total</th>
						</tr>
						<?php foreach ($peeps as $p): ?>
							<tr>
								<td class="avatar"><img src="//github.com/<?php echo $p['name'] ?>.png" class="lilavatar"></td>
								<td><?php echo $p['display'] ?></td>
								<td><?php echo (int) $p['closed_issue'] ?></td>
								<td><?php echo (int) $p['comment'] ?></td>
								<td><?php echo (int) $p['review_passed'] ?></td>
								<td><?php echo (int) $p['merged'] ?></td>
								<td><?php echo (int) $p['new_pr'] ?></td>
								<td><?php echo (int) $p['points'] ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endif; ?>
			<?php endforeach; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
