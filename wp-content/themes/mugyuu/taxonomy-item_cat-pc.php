<?php get_header(); ?>
<?php breadcrumb(); ?>
<div class="mainWrap list">
	<div class="mainArea">
		<section class="articleListArea categoryArea">
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
			<ul class="itemList">
				<?php
				   $args = array(
					   'item_cat' => $taxonomySlug,
					   'posts_per_page' => 9,
					   'post_type' => 'item_post',
					   'paged' => $paged,
				   );
				   $query = new WP_Query($args);
			   ?>
			   <?php
					if ($query->have_posts()) :
					while($query->have_posts()) : $query->the_post(); ?>
				<?php
					$thumbnail_id = get_post_thumbnail_id();
					$image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
				?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
							<img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
						</div>
						<div class="starArea">
							<?php  $score = get_post_meta($post->ID, 'average_score', true);?>
		                    <?php  for($i=0;$i<$score;$i++){ ?>
		                       <i class="fa fa-star on" aria-hidden="true"></i>
		                    <?php } ?>
		                    <?php for($i=5;$score<$i;$i--){?>
		                        <i class="fa fa-star" aria-hidden="true"></i>
		                    <?php } ?>
						</div>
						<h2><?php the_title(); ?></h2>
						<p class="price">
							¥<?php echo( get_post_meta($post->ID, 'item', true)); ?>
						</p>
						<div class="overlay">
							<div class="ovWrap">
								<i class="fa fa-shopping-cart" aria-hidden="true"></i>
								<p>READ MORE</p>
								<div class="bd bdT"></div>
								<div class="bd bdB"></div>
								<div class="bd bdR"></div>
								<div class="bd bdL"></div>
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
