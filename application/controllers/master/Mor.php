<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mor extends CI_Controller {

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
        $crud->set_table('master_mor');   
        $subject = $data['subject'] = 'Master MOR (Marketing Operation Region)';
        $crud->set_subject($subject);
        $crud->set_language('indonesian');

       
        $crud->columns('kode_mor','nama_mor');                 
        
        
        
        $crud->display_as('kode_mor','Kode Mor')
             ->display_as('nama_mor','Nama Mor');
        
               
        $crud->required_fields('kode_mor','nama_mor');                
        $crud->unique_fields(array('kode_mor'));
        
        $data = $crud->render();
        $data->id_user = $id_user;
        $data->level = $level;
        $data->state_data = $crud->getState();
 
        $this->load->view('master/mor/index', $data, FALSE);

    }   
}

/* End of file Berita.php */
/* Location: ./application/controllers/Berita.php */