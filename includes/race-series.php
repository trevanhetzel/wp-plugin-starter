<?php
// The main plugin class
class Race_Series {
	// Loader responsible for maintaining and registering all hooks
	protected $loader;

	// Unique identifier
	protected $plugin_name;

	// Current version
	protected $version;

	// Define the core functionality of the plugin
	public function __construct() {
		$this->plugin_name = 'race-series';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	// Load required dependencies
	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/public.php';

		$this->loader = new Race_Series_Loader();
	}

	// Register admin hooks
	private function define_admin_hooks() {
		$plugin_admin = new Race_Series_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu', 10, 2 );
	}

	// Register public hooks
	private function define_public_hooks() {
		$plugin_public = new Race_Series_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	// Execute all hooks
	public function run() {
		$this->loader->run();
	}

	// Name of the plugin
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	// Reference to the class that orchestrates the hooks with the plugin
	public function get_loader() {
		return $this->loader;
	}

	// Get the version number
	public function get_version() {
		return $this->version;
	}
}
