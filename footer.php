<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Magnus
 */
?>

	</section><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<ul class="site-info">
      <li class="cms-info"><a href="<?php echo esc_url( __( 'http://wordpress.org/', 'magnus' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'magnus' ), 'WordPress' ); ?></a></li>
			<li class="theme-info"><a href="http://thefivethemes.com"><?php printf( __( 'Theme: %1$s by %2$s for %3$s', 'magnus' ), 'Magnus', 'Hugo&nbsp;Baeta', 'The&nbsp;Five&nbsp;Themes' ); ?></a></li>
		</ul><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
