<?php

$num_columns	= 4;
$can_delete	= $this->auth->has_permission('Sales.Admin.Delete');
$can_edit		= $this->auth->has_permission('Sales.Admin.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='row'>
	<div class='col-md-12'>
		<div class='box'>
			<div class='box-header'>
				<h3 class='box-title'>
					<?php echo lang('sales_area_title'); ?>
				</h3>
				<div class='box-tools'>
					<?php if ($can_edit) : ?>
					<a href='<?php echo site_url('/admin/sales/create'); ?>' class='btn btn-success btn-sm'>Add</a>
					<?php endif; ?>
				</div>
			</div>
			<div class='box-body'>
				<?php echo form_open($this->uri->uri_string()); ?>
				<table class='table table-striped'>
					<thead>
						<tr>
							<?php if ($can_delete && $has_records) : ?>
							<th class='column-check'>
								<input class='check-all' type='checkbox' />
							</th>
							<?php endif;?> 
					<th><?php echo lang('sales_field_name'); ?></th>
					<th><?php echo lang('sales_field_quantity'); ?></th>
					<th><?php echo lang('sales_field_price'); ?></th>
					<th><?php echo lang('sales_field_description'); ?></th>
						</tr>
					</thead>
					<?php if ($has_records) : ?>
					<tfoot>
						<?php if ($can_delete) : ?>
						<tr>
							<td colspan='<?php echo $num_columns; ?>'>
								<?php echo lang('sales_with_selected'); ?>
								<input type='submit' name='delete' id='delete-me' class='btn btn-danger btn-sm' 
								value="<?php echo lang('sales_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('sales_delete_confirm'))); ?>')" />
							</td>
						</tr>
						<?php endif; ?>
					</tfoot>
					<?php endif; ?>
					<tbody>
						<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
							<tr>
								<?php if ($can_delete) : ?>
								<td class='column-check'>
									<input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' />
								</td>
								<?php endif;?> 
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(site_url('/admin/sales/edit/' . $record->id), '<span class="icon-pencil"></span> ' .  $record->name); ?></td>
				<?php else : ?>
					<td><?php e($record->name); ?></td>
				<?php endif; ?>
					<td><?php e($record->quantity); ?></td>
					<td><?php e($record->price); ?></td>
					<td><?php e($record->description); ?></td>
							</tr>
							<?php
					endforeach;
				else:
				?>
							<tr>
								<td colspan='<?php echo $num_columns; ?>'>
									<?php echo lang('sales_records_empty'); ?>
								</td>
							</tr>
							<?php endif; ?>
					</tbody>
				</table>
				<?php
    echo form_close();
    
    ?>
			</div>
		</div>
	</div>
</div>