<?php
/**
 * Web Log: Customizer
 *
 * @package web-log
 * @version 1.0.0
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function web_log_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image'  )->transport    = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'web_log_customize_partial_blogname',
	) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'web_log_customize_partial_blogdescription',
	) );
		
	/**
	 * Theme options.
	 */
	 $default = web_log_default_theme_options();
	 
	 $wp_customize->add_panel( 'theme_option_panel',
		array(
			'title'      => esc_html__( 'Theme Options', 'web-log' ),
			'priority'   => 30,
			'capability' => 'edit_theme_options',
		)
	);
	
	// Header Section.
	$wp_customize->add_section( 'section_header',
		array(
			'title'      => esc_html__( 'Header Options', 'web-log' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'theme_option_panel',
		)
	);
	
	
    /*Settings sidebar on front page*/
    $wp_customize->add_setting( 'web_log_sidebar', array(
        'capability'        => 'edit_theme_options',
        'default'           => $default['web_log_sidebar'],
        'sanitize_callback' => 'web_log_sanitize_select'
    ) );
    $wp_customize->add_control( 'web_log_sidebar', array(
        'choices' => array(
                'right-sidebar' => __('Right Sidebar','web-log'),
                'left-sidebar'  => __('Left Sidebar','web-log'),
               
            ),
        'label'         => __( 'Select Sidebar Options', 'web-log' ),
        'section'       => 'web_log_new_section_post',
        'settings'      => 'web_log_sidebar',
        'type'          => 'select',
        'priority'	    => 0
    ) );



	// Setting show_top_header.
	$wp_customize->add_setting( 'show_top_header',
		array(
			'default'           => $default['show_top_header'],
			'sanitize_callback' => 'web_log_sanitize_checkbox',
		)
	);
	
	$wp_customize->add_control( 'show_top_header',
		array(
			'label'    			=> esc_html__( 'Show Header - Top', 'web-log' ),
			'section'  			=> 'section_header',
			'type'     			=> 'checkbox',
			'priority' 			=> 100,
		)
	);
	

	// Breadcrumb Section.
	$wp_customize->add_section( 'section_breadcrumb',
		array(
			'title'      => esc_html__( 'Breadcrumb Options', 'web-log' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'theme_option_panel',
		)
	);
	
	// Setting breadcrumb_type.
	$wp_customize->add_setting( 'breadcrumb_type',
		array(
			'default'           => $default['breadcrumb_type'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'web_log_sanitize_select',
		)
	);
	
	$wp_customize->add_control( 'breadcrumb_type',
		array(
			'label'       => esc_html__( 'Breadcrumb Type', 'web-log' ),
			'section'     => 'section_breadcrumb',
			'type'        => 'radio',
			'priority'    => 100,
			'choices'     => array(
				'disable' => esc_html__( 'Disable', 'web-log' ),
				'normal'  => esc_html__( 'Normal', 'web-log' ),
			),
		)
	);
	
	// Layout Section.
	$wp_customize->add_section( 'web_log_new_section_general' , array(
   		'title'      => esc_html__('Layout Settings','web-log'),
   		'description'=> '',
   		'priority'   => 10,
		'capability' => 'edit_theme_options',
	    'panel'      => 'theme_option_panel',
	) );
	
	// Setting Layout.
	$wp_customize->add_setting(
	        'home_style',
	        array(
	            'default'           => 'Simple',
				'sanitize_callback' => 'sanitize_text_field',
			
	        )
	    );
    	
    $wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'home_layout',
			array(
				'label'       => esc_html__('Home Style Layout','web-log'),
				'section'     => 'web_log_new_section_general',
				'settings'    => 'home_style',
				'type'        => 'radio',
				'priority'	  => 3,
				'choices'     => array(
					'Simple'  => esc_html__('Simple Style Layout','web-log'),
					'Grid'    => esc_html__('Grid Style Layout  [Premium Version]','web-log'),
					'List'    => esc_html__('List Style Layout [Premium Version]','web-log'),
					
				)
			)
		)
	);
    
	
    $wp_customize->add_setting(
        'home_sidebar',
        array(
            'default'           => false,
			'sanitize_callback' => 'web_log_sanitize_checkbox',
        )
    );
	
		
	$wp_customize->add_setting(
        'post_sidebar',
        array(
            'default'           => false,
			'sanitize_callback' => 'web_log_sanitize_checkbox',
        )
    );

	$wp_customize->add_setting(
        'archive_sidebar',
        array(
            'default'           => false,
			'sanitize_callback' => 'web_log_sanitize_checkbox',
        )
    );
	
	$wp_customize->add_setting(
        'pages_sidebar',
        array(
            'default'           => false,
			'sanitize_callback' => 'web_log_sanitize_checkbox',
        )
    );
	
	
   $wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'sidebar_homepage',
			array(
				'label'      => esc_html__('Disable Sidebar on Homepage','web-log'),
				'section'    => 'web_log_new_section_general',
				'settings'   => 'home_sidebar',
				'type'		 => 'checkbox',
				'priority'	 => 4
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'sidebar_post',
			array(
				'label'      => esc_html__('Disable Sidebar on Posts','web-log'),
				'section'    => 'web_log_new_section_general',
				'settings'   => 'post_sidebar',
				'type'		 => 'checkbox',
				'priority'	 => 5
			)
		)
	);
		
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'sidebar_archive',
			array(
				'label'      => esc_html__('Disable Sidebar on Archives','web-log'),
				'section'    => 'web_log_new_section_general',
				'settings'   => 'archive_sidebar',
				'type'		 => 'checkbox',
				'priority'	 => 6
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'pages_archive',
			array(
				'label'      => esc_html__( 'Disable Sidebar on Pages','web-log'),
				'section'    => 'web_log_new_section_general',
				'settings'   => 'pages_sidebar',
				'type'		 => 'checkbox',
				'priority'	 => 6
			)
		)
	);
	
	// Footer Section.
	$wp_customize->add_section( 'section_footer',
		array(
			'title'      => esc_html__( 'Footer Options', 'web-log' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'theme_option_panel',
		)
	);
	
	// Setting copyright_text.
	$wp_customize->add_setting( 'copyright_text',
		array(
			'default'           => $default['copyright_text'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control( 'copyright_text',
		array(
			'label'    => esc_html__( 'Copyright Text', 'web-log' ),
			'section'  => 'section_footer',
			'type'     => 'text',
			'priority' => 100,
		)
	);
	
	
	// Back To Top Section.
	$wp_customize->add_section( 'section_back_to_top',
		array(
			'title'      => esc_html__( 'Back To Top Options', 'web-log' ),
			'priority'   => 100,
			'capability' => 'edit_theme_options',
			'panel'      => 'theme_option_panel',
		)
	);
	
	// Setting breadcrumb_type.
	$wp_customize->add_setting( 'back_to_top_type',
		array(
			'default'           => $default['back_to_top'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'web_log_sanitize_select',
		)
	);
	
	$wp_customize->add_control( 'back_to_top_type',
		array(
			'label'       => esc_html__( 'Active?', 'web-log' ),
			'section'     => 'section_back_to_top',
			'type'        => 'radio',
			'priority'    => 100,
			'choices'     => array(
				'disable' => esc_html__( 'Disable', 'web-log' ),
				'enable'  => esc_html__( 'Enable', 'web-log' ),
			),
		)
	);

	// Post Settings
	
	$wp_customize->add_section( 'web_log_new_section_post' , array(
   		'title'          => esc_html__( 'Post Settings','web-log' ),
   		'description'    => '',
   		'priority'       => 96,
		'capability'     => 'edit_theme_options',
			'panel'      => 'theme_option_panel',
	) );

    
	// Post Settings
	$wp_customize->add_setting(
        'article_tags',
        array(
            'default'          => false,
			'sanitize_callback'=> 'web_log_sanitize_checkbox',
        )
    );

	$wp_customize->add_setting(
        'article_author',
        array(
            'default'          => false,
			'sanitize_callback'=> 'web_log_sanitize_checkbox',
        )
    );

	$wp_customize->add_setting(
        'article_related_post',
        array(
            'default'          => false,
			'sanitize_callback'=> 'web_log_sanitize_checkbox',
        )
    );
	
	$wp_customize->add_setting(
        'article_next_post',
        array(
            'default'          => false,
			'sanitize_callback'=> 'web_log_sanitize_checkbox',
        )
    );
	$wp_customize->add_setting(
        'article_comment_link',
        array(
            'default'          => false,
			'sanitize_callback'=> 'web_log_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_setting(
	        'article_like_link',
	        array(
	            'default'          => false,
				'sanitize_callback'=> 'web_log_sanitize_checkbox',
	        )
	    );

    
		$wp_customize->add_setting(
	        'article_date_area',
	        array(
	            'default'          => false,
				'sanitize_callback'=> 'web_log_sanitize_checkbox',
	        )
	    );
		$wp_customize->add_setting(
	        'post_categories',
	        array(
	            'default'          => false,
				'sanitize_callback'=> 'web_log_sanitize_checkbox',
	        )
	    );
    
  	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'post_cat',
			array(
				'label'      => esc_html__('Hide Category','web-log' ),
				'section'    => 'web_log_new_section_post',
				'settings'   => 'post_categories',
				'type'		 => 'checkbox',
				'priority'	 => 3
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'post_date',
			array(
				'label'      => esc_html__('Hide Date','web-log' ),
				'section'    => 'web_log_new_section_post',
				'settings'   => 'article_date_area',
				'type'		 => 'checkbox',
				'priority'	 => 2
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'post_tags',
			array(
				'label'      =>  esc_html__('Hide Tags','web-log' ),
				'section'    => 'web_log_new_section_post',
				'settings'   => 'article_tags',
				'type'		 => 'checkbox',
				'priority'	 => 5
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'post_share_author',
			array(
				'label'      => esc_html__('Hide Post Navi','web-log' ),
				'section'    => 'web_log_new_section_post',
				'settings'   => 'article_next_post',
				'type'		 => 'checkbox',
				'priority'	 => 8
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'post_comment_link',
			array(
				'label'      => esc_html__('Hide Comment Link','web-log' ),
				'section'    => 'web_log_new_section_post',
				'settings'   => 'article_comment_link',
				'type'		 => 'checkbox',
				'priority'	 => 4
			)
		)
	);
    

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'post_author',
			array(
				'label'      => esc_html__('Hide Author Name','web-log' ),
				'section'    => 'web_log_new_section_post',
				'settings'   => 'article_author',
				'type'		 => 'checkbox',
				'priority'	 => 1
			)
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'post_related',
			array(
				'label'      => esc_html__('Hide Related Posts Box','web-log' ),
				'section'    => 'web_log_new_section_post',
				'settings'   => 'article_related_post',
				'type'		 => 'checkbox',
				'priority'	 => 9
			)
		)
	);

    // Setting Read More Text.
	$wp_customize->add_setting( 'you_may_like_text',
		array(
			'default'           => $default['you_may_like_text'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control( 'you_may_like_text',
		array(
			'label'    => esc_html__( 'Related Posts Text', 'web-log' ),
			'section'  => 'web_log_new_section_post',
			'type'     => 'text',
			'priority' => 100,
		)
	);

     
    // Setting Read More Text.
	$wp_customize->add_setting( 'readmore_text',
		array(
			'default'           => $default['readmore_text'],
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	
	$wp_customize->add_control( 'readmore_text',
		array(
			'label'    => esc_html__( 'Read More Button Text', 'web-log' ),
			'section'  => 'web_log_new_section_post',
			'type'     => 'text',
			'priority' => 100,
		)
	);

		
}


add_action( 'customize_register', 'web_log_customize_register' );


/**
 * Render the site title for the selective refresh partial.
 *
 * @since web-log 1.0
 * @see web_log_customize_register()
 *
 * @return void
 */
function web_log_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since web-log 1.0
 * @see web_log_customize_register()
 *
 * @return void
 */
function web_log_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Return whether we're previewing the front page and it's a static page.
 */
function web_log_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Return whether we're on a view that supports a one or two column layout.
 */
function web_log_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

if ( ! function_exists( 'web_log_sanitize_checkbox' ) ) :

	/**
	 * Sanitize checkbox.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function web_log_sanitize_checkbox( $checked ) {

		return ( ( isset( $checked ) && true === $checked ) ? true : false );

	}

endif;


if ( ! function_exists( 'web_log_sanitize_positive_integer' ) ) :

	/**
	 * Sanitize positive integer.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input Number to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized number; otherwise, the setting default.
	 */
	function web_log_sanitize_positive_integer( $input, $setting ) {

		$input = absint( $input );

		// If the input is an absolute integer, return it.
		// otherwise, return the default.
		return ( $input ? $input : $setting->default );

	}

endif;

if ( ! function_exists( 'web_log_sanitize_select' ) ) :

	/**
	 * Sanitize select.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	function web_log_sanitize_select( $input, $setting ) {

		// Ensure input is clean.
		$input   = sanitize_text_field( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

	}

endif;

if ( ! function_exists( 'web_log_default_theme_options' ) ) :

	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function web_log_default_theme_options() {

		$defaults                               = array();

		// Header.
		$defaults['show_top_header']            = false;

		// Post.
		$defaults['readmore_text']              = esc_html__( 'Read More', 'web-log' );

		$defaults['you_may_like_text']          = esc_html__( 'Related Post', 'web-log' );

		$defaults['web_log_sidebar']            ='right-sidebar';

		//Back To Top
		$defaults['back_to_top']                = 'enable';

		// Footer.
		$defaults['copyright_text']             = esc_html__( 'Copyright &copy; All rights reserved.', 'web-log' );

		// Breadcrumb.
		$defaults['breadcrumb_type']            = 'normal';
		
		//slider active
		$defaults['web-log_feature_post_status']= false;
		
		return $defaults;
	}

endif;

if ( ! function_exists( 'web_log_is_top_header_active' ) ) :

	/**
	 * Check if featured slider is active.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 *
	 * @return bool Whether the control is active to the current preview.
	 */
	function web_log_is_top_header_active( $control ) {

		if ( true == $control->manager->get_setting( 'show_top_header' )->value() ) {
			return true;
		} else {
			return false;
		}

	}

endif;

if ( ! function_exists( 'web_log_get_option' ) ) :

	/**
	 * Get theme option.
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function web_log_get_option( $key ) {

		if ( empty( $key ) ) {

			return;

		}

		$value            = '';

		$default          = web_log_default_theme_options();

		$default_value    = null;

		if ( is_array( $default ) && isset( $default[ $key ] ) ) {

			$default_value = $default[ $key ];

		}

		if ( null !== $default_value ) {

			$value = get_theme_mod( $key, $default_value );

		}else {

			$value = get_theme_mod( $key );

		}

		return $value;

	}

endif;

if ( ! function_exists( 'web_log_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see web-log_custom_header_setup().
 */
function web_log_header_style() { 

$header_text_color = get_header_textcolor();
	if( !empty( $header_text_color ) ): ?>
		<style type="text/css">
			   .site-header a,
			   .site-header p{
					color: #<?php echo esc_attr( $header_text_color ); ?>;
			   }
		</style>
			
		<?php
	endif;
}

endif;

/**
 * Bind JS handlers to instantly live-preview changes.
 */
function web_log_customize_preview_js() {
	wp_enqueue_script( 'web-log-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'web_log_customize_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function web_log_panels_js() {
	wp_enqueue_script( 'web-log-customize-controls', get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'web_log_panels_js' );
