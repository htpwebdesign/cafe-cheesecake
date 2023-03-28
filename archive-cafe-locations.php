<?php
/**
 * The template for displaying Locations archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cafe_Cheesecake
 */

get_header();
?>

	<main id="primary" class="site-main">

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
				$args = array(
					'post_type' => 'cafe-location',
					'post_per_page' => -1,
				);

				$query = new WP_Query($args);
				if($query -> have_posts()){
					echo '<section class="location-container">';
					while($query -> have_posts()){
						$query -> the_post();
	
						if ( function_exists( 'get_field' ) ) {
							?>
							<h2><?php echo the_field('location_name'); ?></h2>
							<p><?php echo the_field('location_information'); ?></p>	
							<?php
							echo wp_get_attachment_image( get_field( 'location_image' ), 'medium', '',
								array(''));
						}
					}
					wp_reset_postdata();
					echo '</section>';
				}

				echo '<section class="googlemaps-container">';
				echo '</section>';
			?>

	</main><!-- #main -->

<?php
get_footer();