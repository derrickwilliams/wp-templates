<?php get_header(); ?>

<div class="content">
										        
	<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
	
		<div class="posts">
	
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
												
				<div class="featured-media">
				
					<?php $image_array = wp_get_attachment_image_src( $post->ID, 'full', false ); ?>
				
					<a href="<?php echo esc_url( $image_array[0] ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
						<?php echo wp_get_attachment_image( $post->ID, 'post-image' ); ?>
                    </a>
				
				</div><!-- .featured-media -->
				
				<div class="post-inner">
					
					<div class="post-header">
					
						<h2 class="post-title"><?php echo basename( get_attached_file( $post->ID ) ); ?></h2>
						
						<div class="post-meta">
						
							<span><?php echo the_time( get_option( 'date_format' ) ); ?></span>
							
							<span class="date-sep"> / </span>
						
							<span><?php echo $image_array[1] . ' <span style="text-transform: lowercase;">x</span> ' . $image_array[2] . ' px'; ?></span>
						
						</div><!-- .post-meta -->
					
					</div><!-- .post-header -->
	
					<?php if ( has_excerpt() ) : ?>
					
						<div class="post-content">
						
							<?php the_excerpt(); ?>
							
						</div><!-- .post-content -->
						
					<?php endif; ?>
											
				</div><!-- .content-inner -->
				
				<div class="post-meta-bottom">
								
					<div class="archive-nav">
					
						<?php
                            /*
                             * Grab the IDs of all the image attachments in a gallery so we can get the URL of
                             * the next adjacent image in a gallery, or the first image (if we're looking at the 
                             * last image in a gallery), or, in a gallery of one, just the link to that image file
                             */
                             
                            $attachments = array_values( 
                                get_children( 
                                    array( 
                                        'order'          => 'ASC',
                                        'orderby'        => 'menu_order ID',
                                        'post_mime_type' => 'image',
                                        'post_parent'    => $post->post_parent, 
                                        'post_status'    => 'inherit', 
                                        'post_type'      => 'attachment'
                                    ) 
                                ) 
                            );
                            
                            foreach ( $attachments as $k => $attachment ) {
                                if ( $attachment->ID == $post->ID )
                                    break;
                            }

                            $l = $k - 1;
                            $k++;

                            if ( isset( $attachments[ $k ] ) ) {
                            
                                // Get the URL of the next image attachment
                                $next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
                                $prev_attachment_url = get_attachment_link( $attachments[ $l ]->ID );
                                
                            } else {
                            
                                // ...Or get the URL of the first image attachment
                                $next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
                                
                            }
                            
                        ?>
                        
						<a href="<?php echo $prev_attachment_url; ?>" class="post-nav-older" rel="attachment"><?php _e( '&laquo; Previous<span> attachment</span>', 'wilson' ); ?></a>
						<a href="<?php echo $next_attachment_url; ?>" class="post-nav-newer" rel="attachment"><?php _e( 'Next<span> attachment</span> &raquo;', 'wilson' ); ?></a>
					
						<div class="clear"></div>
					
					</div><!-- .post-nav -->
				
				</div><!-- .post-meta-bottom -->
				
				<?php comments_template( '', true ); ?>
															                        
			<?php endwhile; 
		
			else: ?>
		
				<p><?php _e( "We couldn't find any posts that matched your query. Please try again.", "wilson" ); ?></p>
			
			<?php endif; ?>
				
		</div><!-- .post -->
		
	</div><!-- .posts -->
	
<?php get_footer(); ?>