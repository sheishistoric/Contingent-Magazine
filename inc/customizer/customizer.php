<?php

/**
 * The Largo_Customizer gives a visually responsive setup interface.
 */
class Largo_Customizer {

	private static $instance;

	private $option_key;

	/**
	 * Get the instance of the Largo Customizer
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {
			self::$instance = new Largo_Customizer;
			self::$instance->load();
		}

		return self::$instance;
	}

	public function __construct() {
		/** Nothing to do **/
	}

	/**
	 * Load the Customizer
	 */
	private function load() {

		$this->setup_actions();

		// See optionsframework_option_name()
		$this->option_key = preg_replace("/\W/", "_", strtolower( get_option( 'stylesheet' ) ) );

	}

	/**
	 * Set up actions for the Customizer
	 */
	private function setup_actions() {

		add_action( 'customize_register', array( $this, 'action_customize_register' ) );
		add_action( 'customize_preview_init', array( $this, 'action_customize_preview_init' ) );

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'action_customize_controls_enqueue_scripts' ) );

	}

	/**
	 * Require files for the Customizer
	 */
	private function require_controls() {

		require_once dirname( __FILE__ ) . '/class-largo-wp-customize-textarea-control.php';
		require_once dirname( __FILE__ ) . '/class-largo-wp-customize-multi-checkbox-control.php';
		require_once dirname( __FILE__ ) . '/class-largo-wp-customize-rich-radio-control.php';

	}

	/**
	 * Get a settings key with its option key prefixed
	 *
	 * @param string $settings_key
	 * @return string
	 */
	private function get_setting_key( $setting_key ) {
		return $this->option_key . $setting_key;
	}

	/**
	 * Register our customizer options
	 */
	public function action_customize_register( $wp_customize ) {

		$this->require_controls();

		// Static front pages aren't commonly used
		$wp_customize->remove_section( 'static_front_page' );

		// Register the settings
		$settings = array(
			'[site_blurb]'          => array(
				'type'                  => 'option',
				'sanitize_callback'     => 'wp_filter_nohtml_kses',
				),
			// Homepage
			'[home_template]'      => array(
				'type'                  => 'option',
				'sanitize_callback'     => 'sanitize_text_field',
				),
			'[num_posts_home]'     => array(
				'type'                  => 'option',
				'sanitize_callback'     => 'absint',
				),
			'[homepage_bottom]'    => array(
				'type'                  => 'option',
				'sanitize_callback'     => 'sanitize_key',
				),
			// Single
			'[single_social_icons]' => array(
				'type'                  => 'option',
				'sanitize_callback'     => 'sanitize_key',
				),
			'[fb_verb]'            => array(
				'type'                  => 'option',
				'sanitize_callback'     => 'sanitize_key',
				),
			// Footer
			'[footer_layout]'      => array(
				'type'                  => 'option',
				'sanitize_callback'     => 'sanitize_key',
				),
			);
		foreach( $settings as $setting => $options ) {
			$wp_customize->add_setting( $this->get_setting_key( $setting ), $options );
		}

		// Site description
		$wp_customize->add_control( new Largo_WP_Customize_Textarea_Control( $wp_customize, 'largo_site_description', array(
			'label'             => __( 'Site Description', 'largo' ),
			'section'           => 'title_tagline',
			'settings'          => $this->get_setting_key( '[site_blurb]' ),
		) ) );

		/**
		 * Homepage layout
		 */
		$wp_customize->add_section( 'largo_homepage', array(
			'title'          => __( 'Home Layout', 'largo' ),
			'priority'       => 20,
			) );

		$home_templates = array();
		$home_templates_data = largo_get_home_layouts();
		if ( count($home_templates_data) ) {
			foreach ($home_templates_data as $name => $data ) {
				$home_templates[ $data['path'] ] = array(
					'img'         => $data['thumb'],
					'label'       => $name,
					'desc'        => $data['desc'],
					);
			}
		}
		$wp_customize->add_control( new Largo_WP_Customize_Rich_Radio_Control( $wp_customize, 'largo_home_template', array(
			'label'              => __( 'Body', 'largo' ),
			'section'            => 'largo_homepage',
			'settings'           => $this->get_setting_key( '[home_template]' ),
			'type'               => 'rich_radio',
			'choices'            => $home_templates,
			) ) );
		$post_choices = array();
		for( $i = 1; $i <= 20; $i++ ) {
			$post_choices[ $i ] = $i;
		}
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'largo_num_posts_home', array(
			'label'              => __( 'Number of Posts', 'largo' ),
			'section'            => 'largo_homepage',
			'settings'           => $this->get_setting_key( '[num_posts_home]' ),
			'type'               => 'select',
			'choices'            => $post_choices
			) ) );
		$wp_customize->add_control( new Largo_WP_Customize_Rich_Radio_Control( $wp_customize, 'largo_homepage_bottom', array(
			'label'              => __( 'Bottom', 'largo' ),
			'section'            => 'largo_homepage',
			'settings'           => $this->get_setting_key( '[homepage_bottom]' ),
			'type'               => 'rich_radio',
			'choices'            => array(
				'list'           => array(
					'label'      => __( 'List', 'largo' ),
					'img'        => get_template_directory_uri() . '/lib/options-framework/images/list.png',
					),
				'widgets'        => array(
					'label'      => __( 'Widgets', 'largo' ),
					'img'        => get_template_directory_uri() . '/lib/options-framework/images/widgets.png',
					),
				'none'           => array(
					'label'      => __( 'None', 'largo' ),
					'img'        => get_template_directory_uri() . '/lib/options-framework/images/none.png',
					),
				),
			) ) );

		/**
		 * Single Post Options
		 */
		$wp_customize->add_section( 'largo_single_post', array(
			'title'          => __( 'Single Post', 'largo' ),
			'priority'       => 24,
			) );
		$services = array( 'facebook', 'twitter', 'print' );
		$service_settings = array();
		foreach( $services as $service ) {
			$service_settings[$service] = $this->get_setting_key( '[article_utilities][' . $service . ']' );
			$wp_customize->add_setting( $this->get_setting_key( '[article_utilities][' . $service . ']' ), array(
				'type'                  => 'option',
				'sanitize_callback'     => 'sanitize_key',
				) );
		}
		$wp_customize->add_control( new Largo_WP_Customize_Multi_Checkbox_Control( $wp_customize, 'largo_article_utilities', array(
			'label'              => __( 'Social Icons to Display', 'largo' ),
			'section'            => 'largo_single_post',
			'settings'           => $service_settings,
			'type'               => 'multi_checkbox',
			'choices'            => array(
				'facebook'       => __( 'Facebook', 'largo' ),
				'twitter'        => __( 'Twitter', 'largo' ),
				'print'          => __( 'Print', 'largo' ),
				),
			) ) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'largo_single_social_icons', array(
			'label'              => __( 'Display Social Icons', 'largo' ),
			'section'            => 'largo_single_post',
			'settings'           => $this->get_setting_key( '[single_social_icons]' ),
			'type'               => 'checkbox',
			) ) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'largo_fb_verb', array(
			'label'              => __( 'Facebook Button Text', 'largo' ),
			'section'            => 'largo_single_post',
			'settings'           => $this->get_setting_key( '[fb_verb]' ),
			'type'               => 'select',
			'choices'            => array(
				// intentionally not translated
				'like'           => 'Like',
				'recommend'      => 'Recommend',
				),
			) ) );

		/**
		 * Footer layout
		 */
		$wp_customize->add_section( 'largo_footer_layout', array(
			'title'          => __( 'Footer Layout', 'largo' ),
			'priority'       => 25,
			) );
		$imagepath =  get_template_directory_uri() . '/lib/options-framework/images/';
		$wp_customize->add_control( new Largo_WP_Customize_Rich_Radio_Control( $wp_customize, 'largo_footer_layout', array(
			'label'              => false,
			'section'            => 'largo_footer_layout',
			'settings'           => $this->get_setting_key( '[footer_layout]' ),
			'type'               => 'rich_radio',
			'choices'            => array(
				'3col-default'	 => array(
					'label'      => __( '3 column large center', 'largo' ),
					'img'        => $imagepath . 'footer-3col-lg-center.png',
				),
				'3col-equal'	 => array(
					'label'      => __( '3 column equal', 'largo' ),
					'img'        => $imagepath . 'footer-3col-equal.png',
				),
				'4col'	 => array(
					'label'      => __( '4 column', 'largo' ),
					'img'        => $imagepath . 'footer-4col.png'
				),
			),
			) ) );

		/**
		 * Colors
		 */
		if ( Largo()->is_less_enabled() ) {

			$wp_customize->add_section( 'largo_colors' , array(
				'title'      => __( 'Colors', 'largo' ),
				'priority'   => 30,
			) );

			$field_groups = Largo_Custom_Less_Variables::get_editable_variables();
			$colors = array();
			foreach( $field_groups as $field_group => $fields ) {

				foreach( $fields as $field_name => $field ) {

					if ( 'color' !== $field['type'] ) {
						continue;
					}

					$colors[ $field_name ] = $field;
				}

			}

			foreach( $colors as $color => $options ) {
				$setting = 'largo_color_' . $color;
				$wp_customize->add_setting( $setting, array(
					'type'              => $setting,
					'default'           => $options['default_value'],
					'sanitize_callback' => 'sanitize_hex_color',
					) );
				$wp_customize->add_control( new WP_Customize_Color_Control(
					$wp_customize,
					$setting,
					array(
						'label'       => $options['label'],
						'section'     => 'largo_colors',
						'settings'    => $setting,
						)
					) );
				$settings[$setting] = array(
					'type'          => $setting,
					);
			}

			add_action( 'customize_save', array( $this, 'action_customize_save_fetch_less_variables' ) );
			add_action( 'customize_save_after', array( $this, 'action_customize_save_after_save_less_variables' ) );

		}

		// Because the Customizer doesn't easily support custom callbacks, let's add our own
		foreach( $settings as $setting => $options ) {

			// These types have native support
			if ( in_array( $options['type'], array( 'option', 'theme_mod' ) ) ) {
				continue;
			}

			add_filter( 'customize_value_' . $setting, array( $this, 'filter_customize_value' ) );

			add_action( 'customize_update_' . $options['type'], array( $this, 'action_customize_update' ) );
			add_action( 'customize_preview_' . $options['type'], array( $this, 'action_customize_preview' ) );
		}

	}

	/**
	 * Add contextual information when the Customizer is loaded
	 */
	public function action_customize_preview_init() {

		add_action( 'wp_footer', array( $this, 'action_preview_wp_footer' ) );

	}

	/**
	 * Enqueue scripts and styles specific to the Largo Customizer
	 */
	public function action_customize_controls_enqueue_scripts() {
		wp_enqueue_script(
			'largo-customizer',
			get_template_directory_uri() . '/inc/customizer/js/customizer.js',
			array( 'jquery' ),
			largo_version()
		);
		wp_enqueue_style(
			'largo-customizer',
			get_template_directory_uri() . '/inc/customizer/css/customizer.css',
			array(),
			largo_version()
		);
	}

	/**
	 * Customizer settings based on context
	 */
	public function action_preview_wp_footer() {

		$settings = array(
			'hidden_sections' => array(),
			);
		if ( ! is_home() ) {
			$settings['hidden_sections'][] = 'largo_homepage';
		}
		if ( ! is_single() ) {
			$settings['hidden_sections'][] = 'largo_single_post';
		}

		?>
		<script type="text/javascript">
			var _wplargoCustomizerPreviewSettings = <?php echo json_encode( $settings ); ?>;
			if ( typeof window.parent.largoCustomizerPreviewSettings == 'function' ) {
				window.parent.largoCustomizerPreviewSettings( _wplargoCustomizerPreviewSettings );
			}
		</script>
		<?php

	}

	/**
	 * Filter customizer values to use our existing settings framework
	 *
	 * @param mixed $default Default registered value for the setting
	 * @return mixed
	 */
	public function filter_customize_value( $default ) {

		$setting = str_replace( 'customize_value_', '', current_filter() );

		if ( 0 === strpos( $setting, 'largo_color_' ) ) {
			$color = str_replace( 'largo_color_', '', $setting );

			$values = Largo_Custom_Less_Variables::get_custom_values();

			if ( ! empty( $values['variables'][$color] ) ) {
				return $values['variables'][$color];
			}

		}

		return $default;

	}

	/**
	 * Handle an update to one of our Customizer settings
	 *
	 * @param mixed $value
	 */
	public function action_customize_update( $value ) {

		// current_filter(), although semantically incorrect, offers backwards compat to 2.5
		$setting = str_replace( 'customize_update_', '', current_filter() );

		// Colors
		if ( 0 === strpos( $setting, 'largo_color_' ) ) {
			$color = str_replace( 'largo_color_', '', $setting );
			$this->less_variables[ $color ] = $value;
		}

	}

	/**
	 * Handle the preview of one of our setting values
	 */
	public function action_customize_preview( $id ) {
		global $wp_customize;

		$setting = str_replace( 'customize_preview_', '', current_filter() );

		if ( 0 === strpos( $setting, 'largo_color_' ) ) {
			$color = str_replace( 'largo_color_', '', $setting );
			$variables = get_transient( 'largo_customizer_less_variables' );
			if ( ! is_array( $variables ) ) {
				$variables = Largo_Custom_Less_Variables::get_custom_values();
			}

			$variables['meta'] = new stdClass;
			$variables['meta']->post_modified_gmt = date( 'Y-m-s H:i:s' );
			$variables['variables'][ $color ] = $wp_customize->get_setting( $setting )->post_value();
			set_transient( 'largo_customizer_less_variables', $variables );
		}

	}

	/**
	 * Cache all of the LESS variables to a class variable for updating
	 */
	public function action_customize_save_fetch_less_variables() {

		$values = Largo_Custom_Less_Variables::get_custom_values();
		$this->less_variables = $values['variables'];

	}

	/**
	 * If the values have changed, save and regenerate the stylesheet
	 */
	public function action_customize_save_after_save_less_variables() {

		$values = Largo_Custom_Less_Variables::get_custom_values();
		if ( $this->less_variables != $values['variables'] ) {
			$variables = array_merge( $values['variables'], $this->less_variables );
			Largo_Custom_Less_Variables::update_custom_values( $variables );
		}

	}

}
