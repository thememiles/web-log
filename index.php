<?php
/**
 * The main template file
 * @package web-log
 * @version 1.0.0
 */

get_header();
$sidebar_class = web_log_get_option( 'web_log_sidebar' );
  
 ?>
    
<div id="content" class="site-content">
	
	<div class="container">
		
		<div class="row">
		 
		  <div <?php if(get_theme_mod('home_sidebar')==true) : ?> class="col-md-12" <?php else: ?>class="col-md-8 <?php echo $sidebar_class; ?>" <?php endif; ?> >
			
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
					
                	    <div class="web-log-post-grid row" >
						
								 <?php
                                    if ( have_posts() ) :
                                        
                                        /* Start the Loop */
                                        while ( have_posts() ) : the_post();
										
										get_template_part( 'template-parts/post/content');
										          
                                    endwhile;
                        
                                    else :
                        
                                        get_template_part( 'template-parts/post/content', 'none' );
                        
                                    endif;
                                ?>
                			</div>
                            <div class="pagination-wrap">
                             
                              <?php the_posts_pagination(); ?>
							
                            </div>
                        </main><!-- #main -->
                    </div><!-- #primary -->
                </div><!-- .col-md-8 -->
					
			<?php if(get_theme_mod('home_sidebar')==false) : ?> 
			
			   <div class="col-md-4">    
                
                <?php get_sidebar(); ?>
            
            </div>
	
<?php endif; ?> 
	        
		</div><!-- .row -->
	</div>
</div>
<?php get_footer();