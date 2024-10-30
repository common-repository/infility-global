<?php
get_header();
global $wp_query;
$keyword = $wp_query->get( 'keyword' ); // array(keyword, slug, description, description2, faq)
$settings = $wp_query->get( 'settings' ); // array()
?>

<div class="kwp-section kwp-banner" style="background-image: url(<?php echo esc_attr( $settings['banner_image'] ); ?>);">
	<div class="kwp-container container">
		<div class="kwp-column">
			<h1><?php echo esc_html( $keyword['keyword'] ); ?></h1>
		</div>
		<div class="kwp-column"></div>
	</div>
</div>

<div class="kwp-section kwp-breadcrumb">
	<div class="kwp-container container">
		<div class="kwp-column">
			<div class="breadcrumb-item">
				<a href="/">Home</a>
			</div>
			<div class="breadcrumb-item icon-wrap">
				<!-- <span class="dashicons dashicons-arrow-right-alt2"></span> -->
				<!-- <i class="fa-solid fa-angle-right"></i> -->
				<i class="fas fa-chevron-right"></i>
			</div>
			<div class="breadcrumb-item">
				<span class=""><?php echo esc_html( $keyword['keyword'] ); ?></span>
			</div>
		</div>
	</div>
</div>

<div class="kwp-section kwp-description1">
	<div class="kwp-container container">
		<div class="kwp-column">
			<!-- <img width="900" height="600" src="/wp-content/uploads/2023/02/P06_S02.webp" class="attachment-full size-full wp-image-5866" alt="shower door customization" loading="lazy" srcset="/wp-content/uploads/2023/02/P06_S02.webp 900w, /wp-content/uploads/2023/02/P06_S02-300x200.webp 300w, /wp-content/uploads/2023/02/P06_S02-768x512.webp 768w, /wp-content/uploads/2023/02/P06_S02-600x400.webp 600w" sizes="(max-width: 900px) 100vw, 900px"> -->
			<img src="<?php echo esc_attr( $settings['whatis_image'] ); ?>" alt="<?php echo esc_attr( $settings['whatis_image_alt'] ); ?>">
		</div>
		<div class="kwp-column">
			<div>
				<h2>what is <?php echo esc_html( $keyword['keyword'] ); ?></h2>
				<div class="divider"></div>
				<p><i><?php echo esc_html( $keyword['description'] ); ?></i></p>
			</div>
		</div>
	</div>
</div>

<div class="kwp-section kwp-desc2">
	<div class="kwp-container container">
		<div class="kwp-column">
			<h2><?php echo esc_html( $keyword['keyword'] ); ?> by <?php echo esc_html( get_bloginfo( 'name' ) ); ?></h2>
			<div class="divider"></div>
			<p><i><?php echo esc_html( $keyword['description2'] ); ?></i></p>
		</div>
	</div>
</div>

<div class="kwp-section kwp-products">
	<div class="kwp-container container">
		<div class="column">
			<h2 class="more">MORE PRODUCTS</h2>
			<div class="cat">
				<?php
					$terms = get_terms( array(
						'taxonomy' => $settings['taxonomy'],
						'hide_empty' => true,
					) );
					foreach ( $terms as $term ) {
						// echo esc_attr( get_term_link( $term ) );
						?>
						<h3 class="category"><?php echo esc_html( $term->name ); ?></h3>
						<div class="products">
							<?php
								$posts = get_posts( array(
									'post_type' => $settings['post_type'],
									'posts_per_page' => 4,
									'orderby' => 'rand',
									'tax_query' => array(
										array(
											'taxonomy' => $settings['taxonomy'],
											'field' => 'slug',
											'terms' => $term->slug,
										),
									),
								) );
								foreach ( $posts as $post ) {
									?>
									<div class="product">
										<div class="image">
											<a href="<?php echo esc_attr( get_permalink( $post ) ); ?>">
												<?php echo get_the_post_thumbnail( $post, 'full' ); ?>
											</a>
										</div>
										<h4 class="title">
											<a href="<?php echo esc_attr( get_permalink( $post ) ); ?>">
												<?php echo esc_html( $post->post_title ); ?>
											</a>
										</h4>
										<!-- <div class="excerpt">
											<?php // echo esc_html( $post->post_excerpt ); ?>
										</div> -->
									</div>
									<?php
								}
							?>
						</div>

						<?php
					}
				?>
			</div>
		</div>
	</div>
</div>

<div class="kwp-section kwp-button" style="--ig-color: red;">
	<div class="kwp-container container">
		<div class="kwp-column">
			<a href="<?php echo esc_attr( $settings['link'] ); ?>" class="button">Contact for more options</a>
		</div>
	</div>
</div>

<div class="kwp-section kwp-why" style="display: none;">
	<div class="kwp-container container">
		<div class="kwp-column">
			<h2>Why choose us for <span class="keyword"><?php echo esc_html( $keyword['keyword'] ); ?></span></h2>
			<div class="list" style="grid-template-columns: repeat(<?php echo esc_attr( count( $keyword['whyus'] ) ); ?>, 1fr);">
				<?php foreach( $keyword['whyus'] as $index => $item ) { ?>
					<div class="item">
						<!-- <img width="800" height="800" src="https://kjbath.com/wp-content/uploads/2023/03/JL711.jpg" class="attachment-large size-large wp-image-9673" alt="" loading="lazy" srcset="https://kjbath.com/wp-content/uploads/2023/03/JL711.jpg 800w, https://kjbath.com/wp-content/uploads/2023/03/JL711-300x300.jpg 300w, https://kjbath.com/wp-content/uploads/2023/03/JL711-150x150.jpg 150w, https://kjbath.com/wp-content/uploads/2023/03/JL711-768x768.jpg 768w, https://kjbath.com/wp-content/uploads/2023/03/JL711-600x600.jpg 600w" sizes="(max-width: 800px) 100vw, 800px"> -->
						<img src="<?php echo esc_attr( $item['image_url'] ); ?>" alt="<?php echo esc_attr( $item['image_alt'] ); ?>">
						<h3><?php echo esc_html( $item['title'] ); ?></h3>
						<p><?php echo esc_html( $item['content'] ); ?></p>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>


<?php
// 开发调试时用
// echo '<link rel="stylesheet" href="/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css">';
// echo '<link rel="stylesheet" href="/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css">';
// echo '<link rel="stylesheet" href="/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.min.css">';
// echo '<link rel="stylesheet" href="/wp-content/plugins/elementor/assets/lib/font-awesome/css/regular.min.css">';
// echo '<link rel="stylesheet" href="/wp-content/plugins/elementor/assets/lib/font-awesome/css/svg-with-js.min.css">';
// echo '<link rel="stylesheet" href="/wp-content/plugins/elementor/assets/lib/font-awesome/css/v4-shims.min.css">';
// echo '<link rel="stylesheet" href="/wp-content/plugins/elementor/assets/lib/font-awesome/css/all.min.css">';

$svgs = [
	'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 7a8 8 0 1 1 0 16 8 8 0 0 1 0-16zm0 2a6 6 0 1 0 0 12 6 6 0 0 0 0-12zm0 1.5l1.323 2.68 2.957.43-2.14 2.085.505 2.946L12 17.25l-2.645 1.39.505-2.945-2.14-2.086 2.957-.43L12 10.5zM18 2v3l-1.363 1.138A9.935 9.935 0 0 0 13 5.049L13 2 18 2zm-7-.001v3.05a9.935 9.935 0 0 0-3.636 1.088L6 5V2l5-.001z"></path></svg>',
	'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M6 21.5c-1.933 0-3.5-1.567-3.5-3.5s1.567-3.5 3.5-3.5c1.585 0 2.924 1.054 3.355 2.5H15v-2h2V9.242L14.757 7H9V9H3V3h6v2h5.757L18 1.756 22.243 6 19 9.241V15L21 15v6h-6v-2H9.355c-.43 1.446-1.77 2.5-3.355 2.5zm0-5c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5 1.5-.672 1.5-1.5-.672-1.5-1.5-1.5zm13 .5h-2v2h2v-2zM18 4.586L16.586 6 18 7.414 19.414 6 18 4.586zM7 5H5v2h2V5z"></path></svg>',
	'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M21 8a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-1.062A8.001 8.001 0 0 1 12 23v-2a6 6 0 0 0 6-6V9A6 6 0 1 0 6 9v7H3a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h1.062a8.001 8.001 0 0 1 15.876 0H21zM7.76 15.785l1.06-1.696A5.972 5.972 0 0 0 12 15a5.972 5.972 0 0 0 3.18-.911l1.06 1.696A7.963 7.963 0 0 1 12 17a7.963 7.963 0 0 1-4.24-1.215z"></path></svg>',
]
?>
<div class="kwp-section kwp-whyus">
	<div class="kwp-bg"></div>
	<div class="kwp-container container">
		<div class="kwp-column left">
			<div style="margin-right: 0px;">
				<img width="800" height="533" src="https://kjbath.com/wp-content/uploads/2023/02/P02_S03.webp" class="attachment-large size-large wp-image-7997" alt="three people checking the quality of shower enclosure" srcset="https://kjbath.com/wp-content/uploads/2023/02/P02_S03.webp 900w, https://kjbath.com/wp-content/uploads/2023/02/P02_S03-300x200.webp 300w, https://kjbath.com/wp-content/uploads/2023/02/P02_S03-768x512.webp 768w, https://kjbath.com/wp-content/uploads/2023/02/P02_S03-600x400.webp 600w" sizes="(max-width: 800px) 100vw, 800px">
			</div>
		</div>
		<div class="kwp-column">
			<h2>Why choose us for <span class="keyword"><?php echo esc_html( $keyword['keyword'] ); ?></span></h2>
			<div class="list">
				<?php foreach( $keyword['whyus'] as $index => $item ) { ?>
					<div class="item">
						<div class="title-wrap" tabindex="0" data-tab="1" role="tab" aria-controls="pp-accordion-tab-content-1851" aria-expanded="true">
							<div class="title-left">
								<span class="title-icon">
									<?php echo $svgs[ $index % count( $svgs ) ]; ?>
								</span>
								<h3 class="title-text"><?php echo esc_html( $item['title'] ); ?></h3>
							</div>
							<div class="toggle-icon">
								<i aria-hidden="true" class="fas fa-chevron-down"></i>
								<!-- <i aria-hidden="true" class="fas fa-angle-up"></i> -->
							</div>
						</div>
						<!-- <img width="800" height="800" src="https://kjbath.com/wp-content/uploads/2023/03/JL711.jpg" class="attachment-large size-large wp-image-9673" alt="" loading="lazy" srcset="https://kjbath.com/wp-content/uploads/2023/03/JL711.jpg 800w, https://kjbath.com/wp-content/uploads/2023/03/JL711-300x300.jpg 300w, https://kjbath.com/wp-content/uploads/2023/03/JL711-150x150.jpg 150w, https://kjbath.com/wp-content/uploads/2023/03/JL711-768x768.jpg 768w, https://kjbath.com/wp-content/uploads/2023/03/JL711-600x600.jpg 600w" sizes="(max-width: 800px) 100vw, 800px"> -->
						<!-- <img src="<?php // echo esc_attr( $item['image_url'] ); ?>" alt="<?php echo esc_attr( $item['image_alt'] ); ?>"> -->
						<!-- <h3></h3> -->
						<p><?php echo esc_html( $item['content'] ); ?></p>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<div class="kwp-section kwp-blogs">
	<div class="kwp-container container">
		<div class="kwp-column">
			<h2>Related blogs</h2>
			<div class="list">
				<?php // get posts
					$posts = get_posts( array(
						'post_type' => 'post',
						'posts_per_page' => 3,
						'orderby' => 'rand',
					) );
					foreach ( $posts as $post ) {
						?>
						<div class="item">
							<div class="img-wrap">
								<?php echo get_the_post_thumbnail( $post, 'full' ); ?>
							</div>
							<h3><a href="<?php echo esc_attr( get_permalink( $post ) ); ?>"><?php echo esc_html( $post->post_title ); ?></a></h3>
							<p class="excerpt">
								<?php echo esc_html( $post->post_excerpt ); ?>
							</p>
							<div class="read-more">
								<a href="<?php echo esc_attr( get_permalink( $post ) ); ?>">Read More</a>
							</div>
							<div class="date"><?php echo esc_html( date( get_option( 'date_format' ) , strtotime( $post->post_date ) ) ); ?></div>
						</div>
						<?php
					}
				?>
				<!-- <div class="item">
					<img width="800" height="800" src="https://kjbath.com/wp-content/uploads/2023/03/JL711.jpg" class="attachment-large size-large wp-image-9673" alt="" loading="lazy" srcset="https://kjbath.com/wp-content/uploads/2023/03/JL711.jpg 800w, https://kjbath.com/wp-content/uploads/2023/03/JL711-300x300.jpg 300w, https://kjbath.com/wp-content/uploads/2023/03/JL711-150x150.jpg 150w, https://kjbath.com/wp-content/uploads/2023/03/JL711-768x768.jpg 768w, https://kjbath.com/wp-content/uploads/2023/03/JL711-600x600.jpg 600w" sizes="(max-width: 800px) 100vw, 800px">
					<h3><a href="">Space-saving</a></h3>
					<p>Shower cabins can be installed in even the smallest of bathrooms, making them an excellent space-saving solution.</p>
					<div class="read-more">
						<a href="">Read More</a>
					</div>
					<div class="date">2023-10-10</div>
				</div> -->
			</div>
		</div>
	</div>
</div>

<div class="kwp-section kwp-faq">
	<h2>FAQ on <?php echo esc_html( $keyword['keyword'] ); ?></h2>
	<div class="kwp-container container">
		<div class="kwp-column img-wrap">
			<img src="<?php echo esc_attr( $settings['faq_image'] ); ?>" alt="<?php echo esc_attr( $settings['faq_image_alt'] ); ?>">
		</div>
		<div class="kwp-column">
			<?php foreach( $keyword['faq'] as $index => $faq ) { ?>
			<h3 class="question"><?php echo esc_html( $faq['question'] ); ?></h3>
			<p class="answer"><?php echo esc_html( $faq['answer'] ); ?></p>
			<?php } ?>
		</div>
	</div>
</div>

<?php
get_footer();
