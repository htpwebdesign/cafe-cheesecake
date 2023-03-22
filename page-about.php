<?php
/**
 * The template for displaying the About page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cafe_Cheesecake
 */

get_header();
?>

	<main id="primary" class="site-main">

	<?php while ( have_posts() ) : the_post(); ?>
 
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header>

				<div class="entry-content">
					<?php
					the_content();

					if ( function_exists ( 'get_field' ) ) {
	
						if ( get_field( 'company_image' ) ) {
							echo wp_get_attachment_image( get_field( 'company_image' ), 'medium', '',
							array(''));
						}
				
						if ( get_field( 'company_heading' ) ) {
							echo '<h2>' . the_field( 'company_heading' ); '</h2>';
						}
						
						if ( get_field( 'company_background' ) ) {
							echo '<p>' . the_field( 'company_background' ); '</p>';
						}

						if ( get_field( 'founder_heading' ) ) {
							echo '<h2>' . the_field( 'founder_heading' ); '</h2>';
						}

						if ( get_field( 'founder_image' ) ) {
							echo wp_get_attachment_image( get_field( 'founder_image' ), 'medium', '',
							array(''));
						}

						if ( get_field( 'founder_name' ) ) {
							// Changing this <p> to <h3> causes founder_bio to become <h3> instead for some reason in the front end
							echo '<h3>' . get_field( 'founder_name' ); '</h3>'; 
						}
						
						if ( get_field( 'founder_bio' ) ) {
							echo '<p>' . get_field( 'founder_bio' ); '</p>';
						}

						if ( get_field( 'our_locations_heading' ) ) {
							echo '<h3>' . get_field( 'our_locations_heading' ); '</h3>';
						}


						$url = get_field( 'read_more_button' );
						if ( get_field( 'read_more_button' ) ) {
							echo "<br>";
							echo '<a href"' . $url . '" class="button">Locations</a>';
						}

						if ( get_field( 'join_our_team_heading' ) ) {
							echo '<h3>' . get_field( 'join_our_team_heading' ); '</h3>';
						}

						if ( get_field( 'join_our_team_description' ) ) {
							echo '<p>' . get_field( 'join_our_team_description' ); '</p>';
						}

						$urljoin = get_field( 'join_our_team_button' );
						if ( get_field( 'join_our_team_button' ) ) {
							echo "<br>";
							echo '<a href"' . $urljoin. '" class="button">Careers</a>';
						}

						if ( get_field( 'join_our_team_image' ) ) {
							echo wp_get_attachment_image( get_field( 'join_our_team_image' ), 'medium', '',
							array(''));
						}

					}
					
					?>
				</div>

			</article>

		<?php endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
