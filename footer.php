<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cafe_Cheesecake
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<?php

			// Get the social menu
			if ( has_nav_menu( 'menu-3' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'menu-3',
				) );
			}

				// Get the footer menu
				if ( has_nav_menu( 'menu-2' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'menu-2',
					) );
				}
				
			echo "<p><b>BAM Cafe</b> created by <a href='https://brandonbirk.ca/'>Brandon Birk</a>,
			<a href='https://anhmaile.com/'>Mai Le</a>, and <a href='https://alexandersheh.com/'>Alex Sheh</a>";
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
