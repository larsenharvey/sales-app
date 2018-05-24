<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Admin controller
 * @created on : 
 * @author :
 * Copyright {year}
 *
 */
class Admin extends Admin_Controller
{
    protected $permissionCreate = 'Sales.Admin.Create';
    protected $permissionDelete = 'Sales.Admin.Delete';
    protected $permissionEdit   = 'Sales.Admin.Edit';
    protected $permissionView   = 'Sales.Admin.View';

    /**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		 $this->load->library('securinator/Auth'); $this->load->model('sales/sales_model');
        $this->lang->load('sales');
        Template::set('page_title', lang('sales_area_title'));
		 Template::set_theme('backend'); $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
	}

	/**
	 * Display a list of sales data.
	 *
	 * @return void
	 */
	public function index()
	{
		$data = array();
        		if ($this->auth->is_logged_in() === false) {
    		redirect(site_url('/admin/check/login'));
 		}
				// Deleting anything?
		if (isset($_POST['delete'])) {
            //$this->auth->restrict($this->permissionDelete);
			$checked = $this->input->post('checked');
			if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

				$result = true;
				foreach ($checked as $pid) {
					$deleted = $this->sales_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
				}
				if ($result) {
					Template::set_message(count($checked) . ' ' . lang('sales_delete_success'), 'success');
				} else {
					Template::set_message(lang('sales_delete_failure') . $this->sales_model->error, 'error');
				}
			}
		}
        
        
        		$data['records'] = $this->sales_model->find_all();
       foreach( $data as $key => $value )
            Template::set($key, $value);
        
		Template::render();
	}
    
    /**
	 * Create a sales object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict($this->permissionCreate);
        
		if (isset($_POST['save'])) {
			if ($insert_id = $this->save_sales()) {
				log_activity($this->auth->user_id(), lang('sales_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'sales');
				Template::set_message(lang('sales_create_success'), 'success');
				redirect(site_url('//admin/sales'));
			}

            // Not validation error
			if ( ! empty($this->sales_model->error)) {
				Template::set_message(lang('sales_create_failure') . $this->sales_model->error, 'error');
            }
		}

		Template::set('subpage_title', lang('sales_action_create'));

		Template::render();
	}
	/**
	 * Allows editing of sales data.
	 *
	 * @return void
	 */
	public function edit()
	{
        $last_seg = count($this->uri->segments);
        $id = $this->uri->segment($last_seg);
		if (empty($id)) {
			Template::set_message(lang('sales_invalid_id'), 'error');

			redirect(site_url('/admin/sales'));
		}
        
		if (isset($_POST['save'])) {
			$this->auth->restrict($this->permissionEdit);

			if ($this->save_sales('update', $id)) {
				log_activity($this->auth->user_id(), lang('sales_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'sales');
				Template::set_message(lang('sales_edit_success'), 'success');
				redirect(site_url('/admin/admin/sales'));
			}

            // Not validation error
            if ( ! empty($this->sales_model->error)) {
                Template::set_message(lang('sales_edit_failure') . $this->sales_model->error, 'error');
			}
		}
        
		elseif (isset($_POST['delete'])) {
			$this->auth->restrict($this->permissionDelete);

			if ($this->sales_model->delete($id)) {
				log_activity($this->auth->user_id(), lang('sales_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'sales');
				Template::set_message(lang('sales_delete_success'), 'success');

				redirect(site_url('/admin/admin/sales'));
			}

            Template::set_message(lang('sales_delete_failure') . $this->sales_model->error, 'error');
		}
        
        Template::set('sales', $this->sales_model->find($id));
        

		Template::set('subpage_title', lang('sales_edit_heading'));
		Template::render();
	}

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Save the data.
	 *
	 * @param string $type Either 'insert' or 'update'.
	 * @param int	 $id	The ID of the record to update, ignored on inserts.
	 *
	 * @return bool|int An int ID for successful inserts, true for successful
     * updates, else false.
	 */
	private function save_sales($type = 'insert', $id = 0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

        // Validate the data
        $this->form_validation->set_rules($this->sales_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

		// Make sure we only pass in the fields we want
		
		$data = $this->sales_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
		if ($type == 'insert') {
			$id = $this->sales_model->insert($data);

			if (is_numeric($id)) {
				$return = $id;
			}
		} elseif ($type == 'update') {
			$return = $this->sales_model->update($id, $data);
		}

		return $return;
	}
}