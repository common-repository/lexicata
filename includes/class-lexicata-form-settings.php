<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class Lexicata_Form_Settings {

	/**
	 * The single instance of Lexicata_Form_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'lf_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_options_page( __( 'Lexicata Settings', 'lexicata-form' ) , __( 'Lexicata Settings', 'lexicata-form' ) , 'manage_options' , $this->parent->_token . '_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    	wp_enqueue_script( 'farbtastic' );

    	// We're including the WP media scripts here because they're needed for the image upload field
    	// If you're not including an image upload then you can leave this function call out
    	wp_enqueue_media();

    	wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
    	wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'lexicata-form' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

        $settings['standard'] = array(
			'title'					=> __( 'Settings', 'lexicata-form' ),
			'description'			=> __( 'Settings to configure your Lexicata Plugin', 'lexicata-form' ),
			'fields'				=> array(
				array(
					'id' 			=> 'authorization_token',
					'label'			=> __( 'Authorization Token' , 'lexicata-form' ),
					'description'	=> __( 'Generated in your Lexicata Account. Go to Settings -> Website or <a href="https://lexicata.com/settings#website">click here</a>', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'Authorization Token', 'lexicata-form' )
				),
                array(
					'id' 			=> 'google_analytics_id',
					'label'			=> __( 'Google Analytics ID' , 'lexicata-form' ),
					'description'	=> __( 'Optional; supply your Google Analytics ID if you want sucessful submissions to be submitted as an GA event' ),
					'type'			=> 'text',
					//'default'		=> '',
					'placeholder'	=> __( 'e.g. UA-XXXXXXXX-Y', 'lexicata-form' )
				),
				array(
					'id' 			=> 'recaptcha_site_key',
					'label'			=> __( 'reCAPTCHA Site Key' , 'lexicata-form' ),
					'description'	=> __( 'Optional; <a href="https://www.google.com/recaptcha/admin">click here</a> to obtain a reCAPTCHA key' ),
					'type'			=> 'text',
					//'default'		=> '',
					'placeholder'	=> __( 'e.g. 89sdfafAAAAAFDSEFdsdOILJLJ89', 'lexicata-form' )
				),
				array(
					'id' 			=> 'recaptcha_secret_key',
					'label'			=> __( 'reCAPTCHA Secret Key' , 'lexicata-form' ),
					'description'	=> __( 'Optional; <a href="https://www.google.com/recaptcha/admin">click here</a> to obtain a reCAPTCHA key' ),
					'type'			=> 'text',
					//'default'		=> '',
					'placeholder'	=> __( 'e.g. 89sdfafAAAAALKJOIUDFsdf7098', 'lexicata-form' )
				),
				array(
					'id' 			=> 'thankyou_uri',
					'label'			=> __( 'Thank You Redirect URI' , 'lexicata-form' ),
					'description'	=> __( 'Optional; User will be redirected here up on successful form submission. Just copy and paste the page Permalink or outside url.', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( '/thank-you-submission/', 'lexicata-form' )
				),
				array(
					'id' 			=> 'domain_blacklist',
					'label'			=> __( 'Domain Blacklist' , 'lexicata-form' ),
					'description'	=> __( 'Optional; a list of domains from which you do not want to receive leads. Put each domain on a seperate line.', 'lexicata-form' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> __( 'example.com', 'lexicata-form' )
				),
            )
		);

		$settings['form_config'] = array(
			'title'					=> __( 'Form Configuration', 'lexicata-form' ),
			'description'			=> __( 'Custom Field Configuration for your Lexicata form', 'lexicata-form' ),
			'fields'				=> array(
                array(
					'id' 			=> 'form_heading',
					'label'			=> __( 'Form Heading' , 'lexicata-form' ),
					'description'	=> __( 'Heading that will sit above the form and let the user know what the form does', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> 'Contact Us',
					'placeholder'	=> __( 'e.g. Contact Us', 'lexicata-form' )
				),

                array(
					'id' 			=> 'firstname_field_label',
					'label'			=> __( 'First Name Field' , 'lexicata-form' ),
					'description'	=> __( 'Field Label', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> 'First Name',
					'placeholder'	=> __( 'e.g. First Name', 'lexicata-form' )
				),
                array(
					'id' 			=> 'firstname_placeholder_label',
					'label'			=> __( '' , 'lexicata-form' ),
					'description'	=> __( 'Placeholder text', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'e.g. First Name', 'lexicata-form' )
				),


                array(
					'id' 			=> 'lastname_field_label',
					'label'			=> __( 'Last Name Field' , 'lexicata-form' ),
					'description'	=> __( 'Field Label', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> 'Last Name',
					'placeholder'	=> __( 'e.g. Last Name', 'lexicata-form' )
				),
                array(
					'id' 			=> 'lastname_placeholder_label',
					'label'			=> __( '' , 'lexicata-form' ),
					'description'	=> __( 'Placeholder text', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'e.g. Last Name', 'lexicata-form' )
				),

                array(
					'id' 			=> 'email_field_label',
					'label'			=> __( 'Email Address Field' , 'lexicata-form' ),
					'description'	=> __( 'Field Label', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> 'Email Address',
					'placeholder'	=> __( 'e.g. Email Address', 'lexicata-form' )
				),
                array(
					'id' 			=> 'email_placeholder_label',
					'label'			=> __( '' , 'lexicata-form' ),
					'description'	=> __( 'Placeholder text', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'e.g. Email Address', 'lexicata-form' )
				),

                array(
					'id' 			=> 'phone_field_label',
					'label'			=> __( 'Phone Number Field' , 'lexicata-form' ),
					'description'	=> __( 'Field Label', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> 'Phone Number',
					'placeholder'	=> __( 'e.g. Phone Number', 'lexicata-form' )
				),
                array(
					'id' 			=> 'phone_placeholder_label',
					'label'			=> __( '' , 'lexicata-form' ),
					'description'	=> __( 'Placeholder text', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'e.g. Phone Number', 'lexicata-form' )
				),

                array(
					'id' 			=> 'message_field_label',
					'label'			=> __( 'Message Field' , 'lexicata-form' ),
					'description'	=> __( 'Field Label', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> 'How can we help you?',
					'placeholder'	=> __( 'e.g. Tell us about your accident', 'lexicata-form' )
				),
                array(
					'id' 			=> 'message_placeholder_label',
					'label'			=> __( '' , 'lexicata-form' ),
					'description'	=> __( 'Placeholder text', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'e.g. Tell us about your accident', 'lexicata-form' )
				),

				array(
					'id' 			=> 'disclaimer_text',
					'label'			=> __( 'Disclaimer Text' , 'lexicata-form' ),
					'description'	=> __( 'If filled out, the disclaimer above will be show along with a required checkbox above the submit button', 'lexicata-form' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> __( 'I agree to the <a href="http://example.com/terms">terms and conditions</a> that the info submitted in this form is not protected by a privilege of confidentiality.', 'lexicata-form' )
				),

                array(
					'id' 			=> 'submit_button_text',
					'label'			=> __( 'Submit Button Text' , 'lexicata-form' ),
					'description'	=> __( 'Call-to-action text for the submit button', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> 'Submit',
					'placeholder'	=> __( 'e.g. Submit', 'lexicata-form' )
                ),
                array(
					'id' 			=> 'submit_button_color',
					'label'			=> __( 'Submit Button Color', 'lexicata-form' ),
					'description'	=> __( 'Use the color wheel or hex code to select the color for the submit button', 'lexicata-form' ),
					'type'			=> 'color',
					'default'		=> '#00aa00'
				),
                array(
					'id' 			=> 'submit_button_text_color',
					'label'			=> __( 'Submit Button Text Color', 'lexicata-form' ),
					'description'	=> __( 'Use the color wheel or hex code to select the color for the submit button text', 'lexicata-form' ),
					'type'			=> 'color',
					'default'		=> '#ffffff'
                ),
                array(
					'id' 			=> 'successful_submit_message',
					'label'			=> __( 'Successful Submit Message' , 'lexicata-form' ),
					'description'	=> __( 'The message a user will see on sucessfully submitting the form' ),
					'type'			=> 'text',
					'default'		=> 'Thank you! Your inquiry has been successfully submitted',
					'placeholder'	=> __( 'e.g. Thanks! We will contact you soon!', 'lexicata-form' )
				),
			)
		);

		$settings['custom_styles'] = array(
			'title'					=> __( 'Custom Styles', 'lexicata-form' ),
			'description'			=> __( 'Custom styles for your Lexicata form', 'lexicata-form' ),
			'fields'				=> array(
				array(
					'id' 			=> 'custom_css',
					'label'			=> __( 'Custom Styles' , 'lexicata-form' ),
					'description'	=> __( 'Optional; customize your form here using CSS', 'lexicata-form' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> __( '#lf_form_container .description { color: blue; font-weight: bold;}', 'lexicata-form' )
				),
			)
		);
        /*
        $settings['standard'] = array(
			'title'					=> __( 'Standard', 'lexicata-form' ),
			'description'			=> __( 'These are fairly standard form input fields.', 'lexicata-form' ),
			'fields'				=> array(
				array(
					'id' 			=> 'text_field',
					'label'			=> __( 'Some Text' , 'lexicata-form' ),
					'description'	=> __( 'This is a standard text field.', 'lexicata-form' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text', 'lexicata-form' )
				),
				array(
					'id' 			=> 'password_field',
					'label'			=> __( 'A Password' , 'lexicata-form' ),
					'description'	=> __( 'This is a standard password field.', 'lexicata-form' ),
					'type'			=> 'password',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text', 'lexicata-form' )
				),
				array(
					'id' 			=> 'secret_text_field',
					'label'			=> __( 'Some Secret Text' , 'lexicata-form' ),
					'description'	=> __( 'This is a secret text field - any data saved here will not be displayed after the page has reloaded, but it will be saved.', 'lexicata-form' ),
					'type'			=> 'text_secret',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text', 'lexicata-form' )
				),
				array(
					'id' 			=> 'text_block',
					'label'			=> __( 'A Text Block' , 'lexicata-form' ),
					'description'	=> __( 'This is a standard text area.', 'lexicata-form' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> __( 'Placeholder text for this textarea', 'lexicata-form' )
				),
				array(
					'id' 			=> 'single_checkbox',
					'label'			=> __( 'An Option', 'lexicata-form' ),
					'description'	=> __( 'A standard checkbox - if you save this option as checked then it will store the option as \'on\', otherwise it will be an empty string.', 'lexicata-form' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'select_box',
					'label'			=> __( 'A Select Box', 'lexicata-form' ),
					'description'	=> __( 'A standard select box.', 'lexicata-form' ),
					'type'			=> 'select',
					'options'		=> array( 'drupal' => 'Drupal', 'joomla' => 'Joomla', 'wordpress' => 'WordPress' ),
					'default'		=> 'wordpress'
				),
				array(
					'id' 			=> 'radio_buttons',
					'label'			=> __( 'Some Options', 'lexicata-form' ),
					'description'	=> __( 'A standard set of radio buttons.', 'lexicata-form' ),
					'type'			=> 'radio',
					'options'		=> array( 'superman' => 'Superman', 'batman' => 'Batman', 'ironman' => 'Iron Man' ),
					'default'		=> 'batman'
				),
				array(
					'id' 			=> 'multiple_checkboxes',
					'label'			=> __( 'Some Items', 'lexicata-form' ),
					'description'	=> __( 'You can select multiple items and they will be stored as an array.', 'lexicata-form' ),
					'type'			=> 'checkbox_multi',
					'options'		=> array( 'square' => 'Square', 'circle' => 'Circle', 'rectangle' => 'Rectangle', 'triangle' => 'Triangle' ),
					'default'		=> array( 'circle', 'triangle' )
				)
			)
        );
        */

        /*
		$settings['extra'] = array(
			'title'					=> __( 'Extra', 'lexicata-form' ),
			'description'			=> __( 'These are some extra input fields that maybe aren\'t as common as the others.', 'lexicata-form' ),
			'fields'				=> array(
				array(
					'id' 			=> 'number_field',
					'label'			=> __( 'A Number' , 'lexicata-form' ),
					'description'	=> __( 'This is a standard number field - if this field contains anything other than numbers then the form will not be submitted.', 'lexicata-form' ),
					'type'			=> 'number',
					'default'		=> '',
					'placeholder'	=> __( '42', 'lexicata-form' )
				),
				array(
					'id' 			=> 'colour_picker',
					'label'			=> __( 'Pick a colour', 'lexicata-form' ),
					'description'	=> __( 'This uses WordPress\' built-in colour picker - the option is stored as the colour\'s hex code.', 'lexicata-form' ),
					'type'			=> 'color',
					'default'		=> '#21759B'
				),
				array(
					'id' 			=> 'an_image',
					'label'			=> __( 'An Image' , 'lexicata-form' ),
					'description'	=> __( 'This will upload an image to your media library and store the attachment ID in the option field. Once you have uploaded an imge the thumbnail will display above these buttons.', 'lexicata-form' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> ''
				),
				array(
					'id' 			=> 'multi_select_box',
					'label'			=> __( 'A Multi-Select Box', 'lexicata-form' ),
					'description'	=> __( 'A standard multi-select box - the saved data is stored as an array.', 'lexicata-form' ),
					'type'			=> 'select_multi',
					'options'		=> array( 'linux' => 'Linux', 'mac' => 'Mac', 'windows' => 'Windows' ),
					'default'		=> array( 'linux' )
				)
			)
		);
         */

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section != $section ) continue;

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) break;
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

        $html = '';
        // Specify custom styles
        $html .= '<style>';
        //$html .= '#lf_logo_area {background-color: white; margin-bottom: 20px; }';
        $html .= '#lexicata_form_settings legend { color: #0eace8; font-weight: bold; } ';
        $html .= '#lexicata_form_settings fieldset { border: 1px solid #dedede; padding-left: 10px; margin-bottom: 20px; }';
        $html .= '#lexicata_form_settings #domain_blacklist { width: 350px; }';
        $html .= 'fieldset#lf_settings_fields input[type=text] { width: 350px; }';
        $html .= '#lexicata_form_settings span.description { display: block; }'; #so they show up on new line
        $html .= '#lf_form_preview {width: 300px; background-color: white; padding: 5px; border: 1px solid #dedede; margin: 5px; }';
        $html .= '#lf_form_preview label.description { display: block; }';
        $html .= '#lf_form_preview input[type=text], #lf_form_preview input[type=email], #lf_form_preview textarea {width: 290px; }';
		$html .= '#lf_form_preview input#lf_disclaimer { float: left; }';
        $html .= '</style>';

		// Build page HTML
		$html .= '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
			//$html .= '<h2>' . __( 'Lexicata Settings' , 'lexicata-form' ) . '</h2>' . "\n";
            $html .= '<div id="lf_logo_area">';
                $html .= '<img src="'.plugins_url('templates/images/lexicata-logo-169x75.png', __FILE__).'" />';
            $html .= '</div>';

			$tab = '';
			if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
				$tab .= $_GET['tab'];
			}

			// Show page tabs
			if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

				$html .= '<h2 class="nav-tab-wrapper">' . "\n";

				$c = 0;
				foreach ( $this->settings as $section => $data ) {

					// Set tab class
					$class = 'nav-tab';
					if ( ! isset( $_GET['tab'] ) ) {
						if ( 0 == $c ) {
							$class .= ' nav-tab-active';
						}
					} else {
						if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
							$class .= ' nav-tab-active';
						}
					}

					// Set tab link
					$tab_link = add_query_arg( array( 'tab' => $section ) );
					if ( isset( $_GET['settings-updated'] ) ) {
						$tab_link = remove_query_arg( 'settings-updated', $tab_link );
					}

					// Output tab
					$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

					++$c;
				}

				$html .= '</h2>' . "\n";
			}

            if(!isset($_GET['tab']) || $_GET['tab'] == 'standard') {
				$html .= '<fieldset>';
					$html .= '<legend>Shortcode</legend>';
					$html .= '<br /><input type="text" readonly="readonly" value="[lexicata-contact-form]" />';
					$html .= '<p>Copy and paste the above shortcode into the page or post you wish to use the contact form on. For example, contact us page.</p>';
				$html .= '</fieldset>';
			}

            $html .= '<fieldset id="lf_settings_fields">';
                $html .= '<legend>Configuration</legend>';

			    $html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
				// Get settings fields
				ob_start();
				settings_fields( $this->parent->_token . '_settings' );
				do_settings_sections( $this->parent->_token . '_settings' );
				$html .= ob_get_clean();

				$html .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'lexicata-form' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			    $html .= '</form>' . "\n";
            $html .= '</fieldset>';

            if(!isset($_GET['tab']) || $_GET['tab'] == 'form_config') {
				#Begin Admin Preview Block #
				$html .= '<fieldset>';
					$html .= '<legend>Form Preview</legend>';
					$html .= '<p>This is sample of the content of the form to be displayed. The actual look and feel of the form will be determined by your Wordpress Theme.</p>';
					$html .= '<div id="lf_form_preview">';
						$instance = Lexicata_Form::instance( __FILE__, '1.0.0' );
						$html .= $instance->setup_contact_form();
					$html .= '</div>';
				$html .= '</fieldset>';
				#End Admin Preview Block #
			}

		$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main Lexicata_Form_Settings Instance
	 *
	 * Ensures only one instance of Lexicata_Form_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Lexicata_Form()
	 * @return Main Lexicata_Form_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __wakeup()

}
