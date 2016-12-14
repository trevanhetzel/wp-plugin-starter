<?php
// Admin-specific functionality
class Race_Series_Admin {

	// Plugin ID
	private $plugin_name;

	// Plugin version
	private $version;

	// Initialize the class and set its properties
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	// Register styles
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
	}

	// Register JavaScript
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'jquery-ui-datepicker' );
	}

	// Create menu items
	public function add_menu() {
		global $submenu;

		// Top level page
		add_menu_page( 'Race series', 'Race series', 'manage_options', 'series-races', 'rs_races');

		// Sub pages
		add_submenu_page( 'series-races', 'Races', 'Races', 'manage_options', 'series-races', 'rs_races');
		add_submenu_page( 'series-races', 'Results', 'Results', 'manage_options', 'series-results', 'rs_results');
		add_submenu_page( 'series-races', 'Members', 'Members', 'manage_options', 'series-members', 'rs_members');
		add_submenu_page( 'series-races', 'Clubs', 'Clubs', 'manage_options', 'series-clubs', 'rs_clubs');

		// Invisible pages
		add_submenu_page( null, 'New Race', 'New Race', 'manage_options', 'series-new-race', 'rs_new_race');

		// Races page
		function rs_races() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}

			include( plugin_dir_path( __FILE__ ) . 'partials/races.php' );
		}

		// New Race page
		function rs_new_race() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}

			include( plugin_dir_path( __FILE__ ) . 'partials/new-race.php' );

			if (!empty($_POST)) {
				global $wpdb;

				$table = $wpdb->prefix . 'rs_races';

				$data = array(
					'date' => $_POST['date'],
					'type' => $_POST['type'],
					'location' => $_POST['location'],
					'club' => $_POST['club'],
					'description' => $_POST['description'],
					'gate_fee' => $_POST['gate_fee'],
					'entry_fee' => $_POST['entry_fee'],
					'sponsors' => $_POST['sponsors'],
					'directions' => $_POST['directions'],
					'map_link' => $_POST['map_link'],
					'start_time' => $_POST['start_time'],
					'mini_time' => $_POST['mini_time']
				);

				$format = array(
					'%s',
					'%s'
				);

				$success = $wpdb->insert( $table, $data, $format );

				if ($success) {
					echo 'data has been saved' ;
				} else {
					echo 'something happened';
				}
			}
		}

		// Results page
		function rs_results() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}

			include( plugin_dir_path( __FILE__ ) . 'partials/results.php' );
		}

		// Members page
		function rs_members() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}

			include( plugin_dir_path( __FILE__ ) . 'partials/members.php' );
		}

		// Clubs page
		function rs_clubs() {
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}

			include( plugin_dir_path( __FILE__ ) . 'partials/clubs.php' );
		}
	}
}
