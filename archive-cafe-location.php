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
				echo '<section class="locations-container">';
					echo '<section class="locations">';
					$args = array(
						'post_type' => 'cafe-location',
						'post_per_page' => -1,
					);

					$query = new WP_Query($args);
					if($query -> have_posts()){
						while($query -> have_posts()){
							echo '<section class="location-single">';
							$query -> the_post();
		
							if ( function_exists( 'get_field' ) ) {
								?>
								<h2><?php echo the_field('location_name'); ?></h2>
								<p><?php echo the_field('location_information'); ?></p>	
								
								<?php
								echo wp_get_attachment_image( get_field( 'location_image' ), '',
									array(''));
							}
							echo '</section>';
						}
						wp_reset_postdata();
						
					}
					echo '</section>';
				echo '</section>';

				echo '<section class="google-maps-container">';
				if( have_rows('all_location_map') ): ?>
					<div class="acf-map" data-zoom="16">
						<?php while ( have_rows('all_location_map') ) : the_row(); 
				
							// Load sub field values.
							$location = get_sub_field('location');
							$title = get_sub_field('title');
							$description = get_sub_field('description');
							?>
							<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>">
								<h3><?php echo esc_html( $title ); ?></h3>
								<p><em><?php echo esc_html( $location['address'] ); ?></em></p>
								<p><?php echo esc_html( $description ); ?></p>
							</div>
					<?php endwhile; ?>
					</div>
				<?php endif; 
				echo '</section>';
			?>
	</main><!-- #main -->

<?php
get_footer();