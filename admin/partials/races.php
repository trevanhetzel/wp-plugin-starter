<?php
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/list-table.php';

$listTable = new Race_Series_List_Table();
$listTable->prepare_items();
?>

<div class="wrap">
	<h1 class="wp-heading-inline">Races</h1>

	<a href="?page=series-new-race" class="page-title-action">Add New</a>

	<hr class="wp-header-end">

	<h2 class="screen-reader-text">Filter race list</h2>

	<ul class="subsubsub">
		<li class="all">
			<a href="#" class="current">All <span class="count">(1)</span></a>
		</li>
	</ul>

	<form id="movies-filter" method="get">
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<?php $listTable->display() ?>
	</form>
</div>
