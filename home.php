<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Magnus
 */

get_header(); ?>

		<?php if ( have_posts() ) : ?>

			<div id="main" class="site-main">
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content-home', get_post_format() ); ?>

			<?php endwhile; ?>
			</div>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<?php get_template_part( 'content', 'none' ); ?>
				</main><!-- #main -->
			</div><!-- #primary -->

		<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
