<?php
class Race_Series_Database {
	protected $rs_db_version;

	// Create database tables upon plugin install or update
	public static function create_tables() {
		global $wpdb;
		$rs_db_version = '1.0';

		$table_name = $wpdb->prefix . 'rs_races';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			date date DEFAULT '0000-00-00' NOT NULL,
			reschedule_date date DEFAULT '0000-00-00' NOT NULL,
			type tinytext NOT NULL,
			location tinytext NOT NULL,
			club tinytext NOT NULL,
			description text NOT NULL,
			gate_fee tinytext NOT NULL,
			entry_fee tinytext NOT NULL,
			sponsors text NOT NULL,
			directions text NOT NULL,
			map_link text NOT NULL,
			mini_time tinytext NOT NULL,
			start_time tinytext NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		// On install
		add_option( 'race_series_db_version', $rs_db_version );

		// After updating plugin
		if ( $installed_ver != $rs_db_version ) {
			update_option( "race_series_db_version", $rs_db_version );
		}
	}
}
