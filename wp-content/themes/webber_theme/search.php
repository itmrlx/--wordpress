<?php get_header(); ?>	

<!-- CONTENT-->


<!-- / CONTENT -->	

	<section class="container no-main-container-content">
		<div class="row">
			<div class="col-xs-12">
				<div class="row container-content">
					<?php include 'side-left.php'; ?>
					<div class="col-xs-9 content catalog-page news-page">
						<header class="catalog-page_header">
							<h1>Результаты поиска:</h1>
						</header>
						<?php if ( have_posts() ) : ?>
							<?php if(have_posts()) : ?>
							<?php while(have_posts()) : the_post(); ?>
								<div class="post">
									<h2><?php the_title(); ?> <span class="date"><?=get_the_date(); ?></span></h2>
									<div class="post-content">
										<?php the_excerpt(); ?>
									</div>
									<a href="<?php the_permalink(); ?>" class="btn btn-default alignright">Перейти</a>
									<div class="clearfix"></div>
								</div>
							<?php endwhile; ?>
								<!-- pagination -->
								<div class="centered">
									<nav>
										<?php if(function_exists('proPagination')) { proPagination(); } ?>
									</nav>
								</div>
							<?php endif; ?>
						<?php else : ?>
								<div class="post">
									<h2>Ничего не найдено</h2>
									<div class="post-content">
										<p><?php _e( 'Простите, но по вашему запросу ничего не найдено, попробуйте еще раз.', '52' ); ?></p>
									</div>
									<div class="clearfix"></div>
								</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php	get_footer(); ?>