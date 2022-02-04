<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bentuk_lahan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->library(array('grocery_CRUD','ajax_grocery_crud'));   
	}		
 
    public function index() {
        $this->load->config('grocery_crud');
        $this->config->set_item('grocery_crud_xss_clean', false);
        $crud = new Ajax_grocery_CRUD();

        $user_sess = $this->function_lib->get_user_level();
        $level = isset($user_sess['level']) ? $user_sess['level'] : "";
        $id_user = isset($user_sess['id_user']) ? $user_sess['id_user'] : "";

        $crud->set_theme('adminlte');
        $crud->set_table('master_bentuk_lahan');        
        $crud->set_subject('Master Bentuk Lahan');
        $crud->set_language('indonesian');

       
        $crud->columns('bentuk_lahan_value','bentuk_lahan_deskripsi');                 
        
        
        
        $crud->display_as('bentuk_lahan_value','Bentuk Lahan')
             ->display_as('bentuk_lahan_desc','Deskripsi');
        
        $crud->set_field_upload('bentuk_lahan_desc','assets/master/bentuk_lahan');        
               
        $crud->required_fields('bentuk_lahan_value','bentuk_lahan_desc');                
        $crud->unique_fields(array('bentuk_lahan_value'));
        
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('master/bentuk_lahan/index', $data, FALSE);

    }   
}

/* End of file Berita.php */
/* Location: ./application/controllers/Berita.php */