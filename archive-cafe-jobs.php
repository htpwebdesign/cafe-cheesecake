<?php
/**
 * The template for displaying Jobs archive
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
				post_type_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<div class="jobs-container">

			<?php
			$terms = get_terms( 
				array(
					'taxonomy' => 'cafe-location-type',
					'order'      => 'ASC',
				) 
			);
			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					?>
					<section class="location-container">

					<h2 class="location-name"><?php echo esc_html( $term->name ); ?></h2>
					<?php
					$args = array(
						'post_type'      => 'cafe-jobs',
						'posts_per_page' => -1,
						'order'          => 'ASC',
						'orderby'        => 'title',
						'tax_query'      => array (
							array (
								'taxonomy' => 'cafe-location-type',
								'field'    => 'slug',
								'terms'    => $term->slug, 
							)
						),

					);
					$query = new WP_Query( $args );
						
						if ( $query -> have_posts() ){
							while ( $query -> have_posts() ) {
								$query -> the_post();
								if ( function_exists( 'get_field' ) ) {
								?>
								<article class="position-container">
                                <h3 class="position-title"><?php the_title(); ?></h3> 
                                <p class="position-description"><?php the_field('position_description'); ?></p> 
								</article>
                                <?php
								}
							}
							wp_reset_postdata();
						}
						?>
					</section>
						<?php
					}
				};
			?>
			</div>

	</main><!-- #main -->

<?php
get_footer();
