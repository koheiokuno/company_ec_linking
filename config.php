<?php
class CELSettingsPage
{
	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_options_page(
			'Settings Admin', 
			'COMPANY EC連携', 
			'manage_options', 
			'cel-setting-admin', 
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page()
	{
		// Set class property
		$this->options = get_option( 'cel_option_name' );
		?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2>COMPANY EC連携 </h2>           
			<form method="post" action="option.php">
			<?php
				// This prints out all hidden setting fields
				settings_fields( 'cel_option_group' );   
				do_settings_sections( 'cel-setting-admin' );
				submit_button(); 
			?>
			</form>
		</div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init()
	{        
		register_setting(
			'cel_option_group', // Option group
			'cel_option_name', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'COMPANY EC連携設定', // Title
			array( $this, 'print_section_info' ), // Callback
			'cel-setting-admin' // Page
		);  

		add_settings_field(
			'cel_db_host', // ID
			'DB 接続ホスト', // Title 
			array( $this, 'db_host_callback' ), // Callback
			'cel-setting-admin', // Page
			'setting_section_id' // Section           
		);      

		add_settings_field(
			'cel_db_user', 
			'DB 接続ユーザー', 
			array( $this, 'db_user_callback' ), 
			'cel-setting-admin', 
			'setting_section_id'
		);      

		add_settings_field(
			'cel_db_pass', 
			'DB 接続パスワード', 
			array( $this, 'db_pass_callback' ), 
			'cel-setting-admin', 
			'setting_section_id'
		);      
		add_settings_field(
			'cel_db_name', 
			'DB 接続DB名', 
			array( $this, 'db_name_callback' ), 
			'cel-setting-admin', 
			'setting_section_id'
		);      
		
		add_settings_field(
			'cel_cart_url', 
			'カートURL', 
			array( $this, 'cart_url_callback' ), 
			'cel-setting-admin', 
			'setting_section_id'
		);      


	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input )
	{
		$new_input = array();
		if( isset( $input['cel_db_host'] ) )
			$new_input['cel_db_host'] = sanitize_text_field( $input['cel_db_host'] );


		if( isset( $input['cel_db_user'] ) )
			$new_input['cel_db_user'] = sanitize_text_field( $input['cel_db_user'] );

		if( isset( $input['cel_db_pass'] ) )
			$new_input['cel_db_pass'] = sanitize_text_field( $input['cel_db_pass'] );

		if( isset( $input['cel_db_name'] ) )
		$new_input['cel_db_name'] = sanitize_text_field( $input['cel_db_name'] );

		if( isset( $input['cel_cart_url'] ) )
			$new_input['cel_cart_url'] = sanitize_text_field( $input['cel_cart_url'] );

		return $new_input;
	}

	/** 
	 * Print the Section text
	 */
	public function print_section_info()
	{
		print '設定情報の入力を行ってください:';
	}



	/** 
	 * Get the settings option array and print one of its values
	 */
	public function db_name_callback()
	{
		printf(
			'<input type="text" id="cel_db_name" name="cel_option_name[cel_db_name]" value="%s" />',
			isset( $this->options['cel_db_name'] ) ? esc_attr( $this->options['cel_db_name']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function db_host_callback()
	{
		printf(
			'<input type="text" id="cel_db_host" name="cel_option_name[cel_db_host]" value="%s" />',
			isset( $this->options['cel_db_host'] ) ? esc_attr( $this->options['cel_db_host']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function db_user_callback()
	{
		printf(
			'<input type="text" id="cel_db_user" name="cel_option_name[cel_db_user]" value="%s" />',
			isset( $this->options['cel_db_user'] ) ? esc_attr( $this->options['cel_db_user']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function db_pass_callback()
	{
		printf(
			'<input type="text" id="cel_db_pass" name="cel_option_name[cel_db_pass]" value="%s" />',
			isset( $this->options['cel_db_pass'] ) ? esc_attr( $this->options['cel_db_pass']) : ''
		);
	}

	/** 
	 * Get the settings option array and print one of its values
	 */
	public function cart_url_callback()
	{
		printf(
			'<input type="text" id="cel_cart_url" name="cel_option_name[cel_cart_url]" value="%s" />',
			isset( $this->options['cel_cart_url'] ) ? esc_attr( $this->options['cel_cart_url']) : ''
		);
	}



}

if( is_admin() )
	$my_settings_page = new CELSettingsPage();