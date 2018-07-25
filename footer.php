<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Jetstats
 */

?>

	</div><!-- #content -->
</div><!-- #page -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'jetstats' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'jetstats' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'jetstats' ), 'SuperJetTools Much Style Happy Time', '<a href="https://sam.blog/" rel="designer">Sam Hotchkiss</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
