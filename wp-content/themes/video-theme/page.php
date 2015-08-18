<?php 
/* Detail page ofr - Pages  */
get_header(); ?>

<div id="content">

	<div id="inner-content" class="row clearfix">

		<div id="main" class="large-9 medium-12 columns" role="main">
		<?php if ( current_theme_supports( 'breadcrumb-trail' )) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>
			<?php if (have_posts()) :
					while(have_posts()): the_post();?>
					<article id="post-<?php $post->ID; ?>" <?php post_class("clearfix"); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
						<header class="article-header">
							<h1 class="page-title"><?php the_title(); ?></h1>
						</header> <!-- end article header -->
										
						<section class="entry-content clearfix" itemprop="articleBody">
							<?php the_content(); ?>
							
						</section> <!-- end article section -->
											
						<footer class="article-footer">
							<p class="clearfix"><?php the_tags("<span class=\'tags\'>" . __("Tags:", "templatic") . "</span> ", ", ", ""); ?></p>
						</footer> <!-- end article footer -->
										
					</article> <!-- end article -->
				<?php comments_template(); ?>				
			<?php endwhile;
			else : ?>
		
				<?php get_template_part( 'partials/content', 'missing' ); ?>

			<?php endif; ?>

		</div> <!-- end #main -->

		<?php get_sidebar(); ?>
		
	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>