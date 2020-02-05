<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Web_Log_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require_once get_template_directory() . '/include/customizer-pro/section-pro.php';

		// Register custom section types.
		$manager->register_section_type( 'Web_Log_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Web_Log_Customize_Section_Pro(
				$manager,
				'web-log',
				array(
					'title'    => esc_html__( 'Premium Verison', 'web-log' ),
					'pro_text' => esc_html__( 'Upgrade To Pro',  'web-log' ),
					'pro_url'  => 'http://thememiles.com/themes/web-log-pro',
					'priority' => 0
				)
			)
		);
	}


	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		require_once get_template_directory() . '/include/customizer-pro/section-pro.php';


		wp_enqueue_script( 'web-log-customize-controls', trailingslashit( get_template_directory_uri() ) . '/include/customizer-pro/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'web-log-customize-controls', trailingslashit( get_template_directory_uri() ) . '/include/customizer-pro/customize-controls.css' );
	}
}

// Doing this customizer thang!
Web_Log_Customize::get_instance();

if ( ! class_exists( 'Web_Log_Customize_Static_Text_Control' ) ){
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;
class Web_Log_Customize_Static_Text_Control extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'static-text';

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

}
}