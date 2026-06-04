<?php
/**
 * Template de artigo individual.
 *
 * @package RMFacilitiesOnePage
 */

get_header();
?>

<section class="section">
	<div class="container content-grid">
		<div>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				// Breadcrumb (se Rank Math não estiver ativo)
				if ( ! function_exists( 'rank_math_the_breadcrumbs' ) ) :
					$cats = get_the_category();
					$cat  = $cats ? $cats[0] : null;
					?>
				<nav class="breadcrumb" aria-label="<?php esc_attr_e( 'Navegação estrutural', 'rmfacilities-onepage' ); ?>">
					<ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<a itemprop="item" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span itemprop="name"><?php esc_html_e( 'Início', 'rmfacilities-onepage' ); ?></span></a>
							<meta itemprop="position" content="1" />
						</li>
						<?php if ( $cat ) : ?>
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<a itemprop="item" href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><span itemprop="name"><?php echo esc_html( $cat->name ); ?></span></a>
							<meta itemprop="position" content="2" />
						</li>
						<?php endif; ?>
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<span itemprop="name"><?php the_title(); ?></span>
							<meta itemprop="position" content="<?php echo $cat ? 3 : 2; ?>" />
						</li>
					</ol>
				</nav>
				<?php endif; ?>

				<article <?php post_class( 'post-single' ); ?> id="post-<?php the_ID(); ?>" itemscope itemtype="https://schema.org/Article">
					<header>
						<p class="post-meta">
							<time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							<?php $cats = get_the_category(); if ( $cats ) : ?> | <?php the_category( ', ' ); ?><?php endif; ?>
						</p>
						<h1 itemprop="headline"><?php the_title(); ?></h1>
					</header>

					<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumb" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
							<?php the_post_thumbnail( 'large', array( 'itemprop' => 'url' ) ); ?>
						</div>
					<?php endif; ?>

					<div class="post-content" itemprop="articleBody">
						<?php the_content(); ?>
					</div>

					<footer class="post-footer">
						<?php the_tags( '<p><strong>Tags:</strong> ', ', ', '</p>' ); ?>
						<?php
						// Navegação entre posts (melhora engajamento e links internos)
						$prev = get_previous_post();
						$next = get_next_post();
						if ( $prev || $next ) :
							?>
							<nav class="post-navigation" aria-label="<?php esc_attr_e( 'Navegação entre artigos', 'rmfacilities-onepage' ); ?>">
								<?php if ( $prev ) : ?>
								<div class="nav-previous">
									<span><?php esc_html_e( '&larr; Artigo anterior:', 'rmfacilities-onepage' ); ?></span>
									<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><?php echo esc_html( get_the_title( $prev ) ); ?></a>
								</div>
								<?php endif; ?>
								<?php if ( $next ) : ?>
								<div class="nav-next">
									<span><?php esc_html_e( 'Próximo artigo:', 'rmfacilities-onepage' ); ?></span>
									<a href="<?php echo esc_url( get_permalink( $next ) ); ?>"><?php echo esc_html( get_the_title( $next ) ); ?></a>
								</div>
								<?php endif; ?>
							</nav>
						<?php endif; ?>
					</footer>
				</article>

				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php
get_footer();
					</footer>
				</article>

				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</section>

<?php
get_footer();
