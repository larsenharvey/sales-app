<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-danger fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('sales_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($sales->id) ? $sales->id : '';

?>
<div class='admin-box container'>
    <h3>
   		<?php echo lang('sales_area_title'); ?>
    </h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <div class="form-group<?php echo form_error('name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('sales_field_name') . '*', 'name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='name' type='text' required='required' name='name' maxlength='50' value="<?php echo set_value('name', isset($sales->name) ? $sales->name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('name'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('quantity') ? ' error' : ''; ?>">
                <?php echo form_label(lang('sales_field_quantity') . '*', 'quantity', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='quantity' type='text' required='required' name='quantity'  value="<?php echo set_value('quantity', isset($sales->quantity) ? $sales->quantity : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('quantity'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('price') ? ' error' : ''; ?>">
                <?php echo form_label(lang('sales_field_price') . '*', 'price', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='price' type='text' required='required' name='price'  value="<?php echo set_value('price', isset($sales->price) ? $sales->price : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('price'); ?></span>
                </div>
            </div>

            <div class="form-group<?php echo form_error('description') ? ' error' : ''; ?>">
                <?php echo form_label(lang('sales_field_description') . '*', 'description', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='description' type='text' required='required' name='description' maxlength='256' value="<?php echo set_value('description', isset($sales->description) ? $sales->description : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('description'); ?></span>
                </div>
            </div>
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('sales_action_edit'); ?>" />
            <?php echo anchor(site_url('/admin/sales'), lang('sales_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Sales.Admin.Delete')) : ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('sales_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('sales_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>