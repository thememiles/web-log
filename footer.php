<?php
/**
 * The template for displaying the footer
 * @package web-log
 * @version 1.0.0
 */

?>

<!--================================
        START FOOTER AREA
    =================================-->
    <footer class="footer-area">
           
      <?php get_template_part( 'template-parts/footer/site', 'info' ); ?>

    </footer>
    
<!--================================
    END FOOTER AREA
    =================================-->
	
</div><!-- #page -->

<?php $back_to_top_type = web_log_get_option( 'back_to_top_type' );

if($back_to_top_type == 'enable'): ?>

<a href="#page" class="back-to-top" id="back-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>

<?php endif; ?>

<?php wp_footer(); ?>

</body>

</html>
