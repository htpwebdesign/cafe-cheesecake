<?php
/**
 * The template for displaying the Catering page
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
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<?php
		while ( have_posts() ) :
			// outputs form and header
			the_post();

			$args = array(
				'post_type'      => 'cafe-catering',
				'posts_per_page' => -1,
				'order'          => 'ASC',
				'orderby'        => 'title',
			)
			;
			
			$query = new WP_Query( $args );
			?>
			<!-- output image -->
			<section class="image-container">
				<?php
				if ( get_field( 'catering_image' ) ) {
					echo wp_get_attachment_image( get_field( 'catering_image' ), '',
					array(''));
				}
				?>
			</section>

			<?php
			if ( $query -> have_posts() ){
				?>
				<section class="catering-container">
					<section class=catering>
					<?php
					while ( $query -> have_posts() ) {
						$query -> the_post();
						if ( function_exists( 'get_field' ) ) {
							echo '<article class="catering-options">';
							if ( get_field( 'service_type_title' ) ) {
							
								echo '<h2 id="'. esc_attr( get_the_ID() ) . '">' . esc_html( get_the_title() ) .'</h2>';
								?>
								<p class="catering-option-description"> 
								<?php
								the_field( 'service_type_description'); ?>
								</p>
								<?php
							}
							echo '</article>';
							}
						} 
					}
					?>
					</section>
				</section>
				<?php
				wp_reset_postdata();
			?>

			<!-- output faq -->
			<section class="faq-container">
				<section class=faq>
				<?php
				if ( have_rows( 'faq_section' )):
						$myArray = get_field_object( 'faq_section'); ?>
						<h2 class="faq-heading">
						<?php
						echo $myArray['label']; ?>
						</h2>

						<?php
							while ( have_rows( 'faq_section' )) : the_row(); ?>
							<article class="individual-faq-container">
							<details>
								<summary class="faq-question">
								<?php echo get_sub_field( 'faq_question' ); ?> 
								</summary>
							
								<div class="faq-answer">
								<?php echo get_sub_field( 'faq_answer' ); ?> 
								</div>
							</details>
							</article>

							<?php
							endwhile;
							?>
					<?php
				endif;
				?>
				</section>
			</section>

			<section class="catering-form-container">
				<section class="catering-form">
				<?php
				if ( function_exists( 'get_field' ) ) {
					if ( get_field( 'catering_inquiry_form_heading' ) ) { ?>
						<h2 class="catering-inquiry-form-heading">
					<?php
						echo get_field('catering_inquiry_form_heading'); ?>
						</h2>
					<?php
					}
				}
				the_content(); ?>
				<?php
				endwhile; // End of the loop.
				?>
				</section>
			</section>
	</main><!-- #main -->

<?php
get_footer();
