<?php get_header(); ?>
<?php breadcrumb(); ?>
<div class="mainWrap list">
	<div class="mainArea">
		<section class="articleListArea categoryArea recipeArea">
			<?php
				$cat = get_queried_object();
				$catName = $cat->name;
				$catDiscription = $cat->description;
				$catId = $cat->cat_ID;
				$taxonomySlug = $cat->slug;
			?>
			<h1 class="heading">
				<?php echo $catName; ?>
			</h1>
			<p class="ttl">
				<?php echo $catDiscription; ?>
			</p>
			<ul class="recipeList">
				<?php
				   $args = array(
					   'movingimage_cat' => $taxonomySlug,
					   'posts_per_page' => 10,
					   'post_type' => 'movingimage_post',
					   'paged' => $paged,
				   );
				   $query = new WP_Query($args);
			   ?>
			   <?php
					if ($query->have_posts()) :
					while($query->have_posts()) : $query->the_post(); ?>
				<?php
					$thumbnail_id = get_post_thumbnail_id();
					$image = wp_get_attachment_image_src( $thumbnail_id, '320_thumbnail' );
				?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<div class="content">
							<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
								<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
							</div>
							<h2><?php the_title(); ?></h2>
							<div class="overlay">
								<div class="ovWrap">
									<div class="ttlArea">
										<span class="icon icon-recipe"></span>
										<p>LET'S TRY</p>
									</div>
								</div>
							</div>
						</div>
					</a>
				</li>
			<?php endwhile; else: ?>
			<li class="none">該当する記事がありません。</li>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			</ul>
			<?php if (function_exists("pagination")) {
				pagination($query->max_num_pages);
				}
			?>
		</section>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
