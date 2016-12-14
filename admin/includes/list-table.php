<?php
if (!class_exists('WP_List_Table')) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Race_Series_List_Table extends WP_List_Table {
	var $example_data = array(
		array(
			'ID'				=> 1,
			'date'			=> '10/12/2017',
			'location'	=> 'Tabor, IA',
			'type'			=> 'Hare scramble',
			'club'			=> 'Bluff Busters'
		),
		array(
			'ID'				=> 1,
			'date'			=> '10/15/2017',
			'location'	=> 'Tabor, IA',
			'type'			=> 'Enduro',
			'club'			=> 'Bluff Busters'
		),
		array(
			'ID'				=> 1,
			'date'			=> '10/15/2017',
			'location'	=> 'Tabor, IA',
			'type'			=> 'Hare scramble',
			'club'			=> 'Bluff Busters'
		)
	);

	function __construct(){
		global $status, $page;

		// Set parent defaults
		parent::__construct( array(
			'singular'	=> 'race', // singular name of the listed records
			'plural'		=> 'races', // plural name of the listed records
			'ajax'			=> false // does this table support ajax?
		) );
	}

	function column_default($item, $column_name){
		switch($column_name){
			case 'date':
				return '<a href="#">' . $item[$column_name] . '</a>';
			case 'location':
			case 'type':
				return $item[$column_name];
			case 'club':
				return '<a href="#">' . $item[$column_name] . '</a>';
			default:
				return print_r($item,true); // Show the whole array for troubleshooting purposes
		}
	}

	function column_title($item){
		// Build row actions
		$actions = array(
			'edit'		=> sprintf('<a href="?page=%s&action=%s&movie=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
			'delete'	=> sprintf('<a href="?page=%s&action=%s&movie=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
		);

		// Return the title contents
		return sprintf('%1$s %3$s',
			/*$1%s*/ $item['title'],
			/*$2%s*/ $item['ID'],
			/*$3%s*/ $this->row_actions($actions)
		);
	}

	function column_cb($item){
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'], // Let's simply repurpose the table's singular label ("race")
			/*$2%s*/ $item['ID'] // The value of the checkbox should be the record's id
		);
	}

	function get_columns(){
		$columns = array(
			'cb'				=> '<input type="checkbox" />', // Render a checkbox instead of text
			'date'			=> 'Date',
			'location'	=> 'Location',
			'type'			=> 'Type',
			'club'			=> 'Club'
		);

		return $columns;
	}

	function get_sortable_columns() {
		$sortable_columns = array(
			'date'			=> array('date', false), // true means it's already sorted
			'type'		=> array('type', false)
		);

		return $sortable_columns;
	}

	function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete'
		);

		return $actions;
	}

	function process_bulk_action() {
		// Detect when a bulk action is being triggered...
		if( 'delete'===$this->current_action() ) {
			wp_die('Items deleted (or they would be if we had items to delete)!');
		}
	}

	function prepare_items() {
		global $wpdb; // This is used only if making any database queries

		$per_page = 50;
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->process_bulk_action();
		$data = $this->example_data;

		function usort_reorder($a,$b){
			$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title'; // If no sort, default to title
			$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; // If no order, default to asc
			$result = strcmp($a[$orderby], $b[$orderby]); // Determine sort order
			return ($order==='asc') ? $result : -$result; // Send final sort direction to usort
		}

		usort($data, 'usort_reorder');


		/***********************************************************************
		 * ---------------------------------------------------------------------
		 * vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
		 *
		 * In a real-world situation, this is where you would place your query.
		 *
		 * For information on making queries in WordPress, see this Codex entry:
		 * http://codex.wordpress.org/Class_Reference/wpdb
		 *
		 * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
		 * ---------------------------------------------------------------------
		 **********************************************************************/

		$current_page = $this->get_pagenum();
		$total_items = count($data);
		$data = array_slice($data,(($current_page-1)*$per_page),$per_page);

		$this->items = $data;

		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		) );
	}
}
