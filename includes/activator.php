<?php
// Fired during plugin activation
class Race_Series_Activator {
	public static function activate() {
		require_once plugin_dir_path( __FILE__ ) . 'database.php';

		Race_Series_Database::create_tables();
	}
}
