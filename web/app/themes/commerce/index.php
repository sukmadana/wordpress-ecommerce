<?php

get_header();
?>
<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<?php the_content(); ?>
			<?php endwhile; // End of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php
get_footer();
