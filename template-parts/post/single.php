<?php
/**
 * Template part for displaying posts
 * @package web-log
 * @version 1.0.0
 */

 $breadcrumb_type = web_log_get_option( 'breadcrumb_type' );

 if($breadcrumb_type == 'normal'): ?>
        <div class="header-breadcrumb">
            <?php web_log_breadcrumb_trail(); ?>
        </div>
<?php endif; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-wrapper">
		
		<header class="entry-header">
		
		   <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        
        	<ul class="entry-meta list-inline">
                
				<?php web_log_posted_on(); ?>
				
				
				<?php	if(!get_theme_mod('post_categories')) :?>
                
				<?php if( has_category()):
                        echo '<li class="meta-categories list-inline-item"><i class="fa fa-folder-o" aria-hidden="true"></i>';
                            the_category( ',' );
                        echo '</li>';
				endif; ?>
                
				<?php endif; ?>
				
				
				<?php	if(!get_theme_mod('article_comment_link')) :?>
				
				<li class="meta-comment list-inline-item">
                    <?php $cmt_link = get_comments_link(); 
						  $num_comments = get_comments_number();
							if ( $num_comments == 0 ) {
								$comment = __( 'No Comments', 'web-log' );
							} elseif ( $num_comments > 1 ) {
								$comment = $num_comments . __( ' Comments', 'web-log' );
							} else {
								$comment = __('1 Comment', 'web-log' );
							}
					?>	
					<i class="fa fa-comment-o" aria-hidden="true"></i>
                    <a href="<?php echo esc_url( $cmt_link ); ?>"><?php echo esc_html( $comment );?></a>
                </li>
					<?php endif; ?>
                
			</ul>
        
        </header><!-- .entry-header -->
        
		<?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail">
                
                <?php the_post_thumbnail('full'); ?>
            </div>
		<?php endif; ?>
        
        <div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		
		<?php	if(!get_theme_mod('article_tags') && has_tag()) :?>
        
        <div class="entry-footer">
		
		<div class="meta-left">
			
		<?php if(has_tag()): ?>
			<div class="tag-list"><?php the_tags( '<i class="fa fa-tags" aria-hidden="true"></i>'); ?></div>
		<?php endif; ?>
		
		</div>
			
        </div>
     <?php endif; ?>
	</div>
</article><!-- #post-## -->

