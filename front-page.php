<?php
/**
 * The template for displaying the Home page
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

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );
			?>
			<section class="home-blog">
				<h2><?php esc_html_e( 'Latest News', 'rinhae' )?></h2><?php
				$args = array(
					'post_type'      => 'post',
					'posts_per_page' => 3,
				);
				
				$query = new WP_Query( $args );
				
				if ( $query->have_posts() ){
					while ( $query->have_posts() ) {
						$query->the_post(); 
						?>

						<article>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail(); ?>
								<h3><?php the_title(); ?></h3>
							</a>
						</article>		
						<?php			
					}
					wp_reset_postdata();
				}
				?>
				</section>
		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
