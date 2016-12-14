<div class="wrap">
	<h1 class="wp-heading-inline">Add New Race</h1>

	<hr class="wp-header-end">

	<form method="post">
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="date">Date</label></th>
					<td><input name="date" id="date" class="date" type="text" class="regular-text" value=""></td>
				</tr>
				<tr>
					<th><label for="location">Location</label></th>
					<td><input name="location" id="location" type="text" class="regular-text" value=""></td>
				</tr>
				<tr>
					<th><label for="date">Type</label></th>
					<td><input name="date" id="date" type="text" class="regular-text" value=""></td>
				</tr>
				<tr>
					<th><label for="date">Club</label></th>
					<td><input name="date" id="date" type="text" class="regular-text" value=""></td>
				</tr>
			</tbody>
		</table>

		<?php submit_button(); ?>
	</form>
</div>

<script>
	(function ($) {
		
	})(jQuery);
</script>
