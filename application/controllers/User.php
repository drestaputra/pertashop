<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('grocery_CRUD','ajax_grocery_crud'));   
		
	}
	public function login()
	{
		$this->load->model('Muser');
		if (!empty($this->session->userdata('user'))) {
			redirect(base_url('user/dashboard'));
		}
		$this->load->view('user/login');
		if ($this->input->post()) {			
			$response=$this->Muser->cekLogin();			
			if ($response['status']==200) {
				redirect(base_url('dashboard'));
			}else{
				redirect(base_url().'user/login?status='.$response['status'].'&msg='.base64_encode($response['msg']).'');
			}
		}
	}

	public function dashboard(){
		
		// $user_sess = $this->function_lib->get_user_level();
  //       $level = isset($user_sess['level']) ? $user_sess['level'] : "";
        $id_user = isset($user_sess['id_user']) ? $user_sess['id_user'] : "";
		// $this->function_lib->cek_auth(array('admin'));		
		$data = array();
		// $id_opd_admin = $this->function_lib->get_one('id_opd_admin','admin','id_admin='.$this->db->escape($id_user).'');
		// $data['dataOpd'] = $this->Mopd->getAllOpd('id_opd = '.$this->db->escape($id_opd_admin).'');
		// $data['dataKecamatan'] = $this->Malamat->getAllKecamatan("3305");
		// $data['count_aset_idle'] = $this->Maset->count_aset_by_status("idle",'(id_opd_aset = '.$this->db->escape($id_opd_admin).' OR id_opd_aset="0")');
		// $data['count_aset_non_idle'] = $this->Maset->count_aset_by_status("non_idle", '(id_opd_aset = '.$this->db->escape($id_opd_admin).' OR id_opd_aset="0")');

		// $data['count_aset_valid'] = $this->Maset->count_aset_by_status_verifikasi("valid", '(id_opd_aset = '.$this->db->escape($id_opd_admin).' OR id_opd_aset="0")');
		// $data['count_aset_tidak_valid'] = $this->Maset->count_aset_by_status_verifikasi("tidak_valid", '(id_opd_aset = '.$this->db->escape($id_opd_admin).' OR id_opd_aset="0")');
		// $data['count_aset_sedang_diverifikasi'] = $this->Maset->count_aset_by_status_verifikasi("sedang_diverifikasi", '(id_opd_aset = '.$this->db->escape($id_opd_admin).' OR id_opd_aset="0")');
		
		// $data['count_aset_by_opd'] = $this->Maset->count_aset_by_opd('(id_opd ='.$this->db->escape($id_opd_admin).' OR id_opd="0")');
		$this->load->view('user/dashboard',$data,false);	
	}

	public function lupass(){
		header("Content-type: Application/json");
		$this->load->model('Madmin');
		$status = 500;
		$msg = "";
		if (!empty($this->session->userdata('admin'))) {
			$status = 500;
			$msg = "Anda sudah login";
		}		
		if (!empty($this->input->post('email'))) {			
			$lupass=$this->Madmin->lupass();			
			$status = isset($lupass['status']) ? $lupass['status'] : 500;
			$msg = isset($lupass['msg']) ? $lupass['msg'] : "";			
		}
		$response = array(
			"status" => $status,
			"msg" => $msg,
		);
		echo(json_encode($response));
	}
	public function logout(){
		$this->session->sess_destroy('admin');
		redirect(base_url());
	}
	public function profil(){
		$this->load->model('Madmin');
		$this->load->model('Mopd');
		if (empty($this->session->userdata('admin'))) {
			redirect(base_url('admin/login'));
			exit();
		}
		$idadmin = $this->session->userdata('admin')['id_admin'];                
		if ($this->input->post('edit')) {
			$response = $this->Madmin->editProfil();
			if (!empty($response)) {
				$status = $response['status'];
				$msg = $response['msg'];
				redirect('user/admin/profil?status='.$status.'&msg='.base64_encode($msg).'');
			}else{
				redirect('user/admin/profil');
			}
		}else if($this->input->post('change_password')){
			$response = $this->Madmin->changePassword($idadmin);
			if (!empty($response)) {
				$status = $response['status'];
				$msg = $response['msg'];
				redirect('user/admin/profil?status='.$status.'&msg='.base64_encode($msg).'');
			}else{
				redirect('user/admin/profil');
			}
		}
		$data['opd'] = $this->Mopd->getAllOpd();
		$data['profil'] = $this->function_lib->get_row('admin','id_admin="'.$idadmin.'"');
		$this->load->view('user/admin/profil',$data,FALSE);
	}


    public function link_ubah_password($value, $row){
        return '<a href="'.base_url("user/admin/ubah_password/".$row->id_admin).'" class="btn btn-info btn-sm"><i class="fa fa-key"></i></a>';
    }


	public function cpass($post_array,$primary_key){
		$this->function_lib->cek_auth(array('super_admin'));
        $hash = hash('sha512',$post_array['password'] . config_item('encryption_key'));
        $this->db->set("password",$hash);
        $this->db->where('id_admin', $primary_key);
        $this->db->update('admin');
     
        return true;
    }

	public function ubah_password($id_admin){
		$this->function_lib->cek_auth(array('super_admin'));
        $user_sess = $this->function_lib->get_user_level();
        $level = isset($user_sess['level']) ? $user_sess['level'] : "";
        $id_user = isset($user_sess['id_user']) ? $user_sess['id_user'] : "";
        $id_admin = $this->function_lib->get_one('id_admin','admin','id_admin="'.$id_admin.'"');
        if (empty($id_admin) AND ($level!="owner" OR $level!="kasir")) {
            redirect(base_url().'user/admin/index/');
            exit();
        }else{
            $data['id_admin'] = $id_admin;
            $this->load->view('user/admin/ubah_password', $data, FALSE);
        }
        
    }
    public function change_password($id_admin){
        $this->function_lib->cek_auth(array('super_admin'));
        if($this->input->post('change_password')){
            $this->load->model('Madmin');
            $validasiChangePassword = $this->Madmin->changePassword($id_admin); 
            header('Content-Type: application/json');                       
            $status = isset($validasiChangePassword['status']) ? $validasiChangePassword['status'] : 500;
            $msg = isset($validasiChangePassword['msg']) ? $validasiChangePassword['msg'] : 500;
            $error = isset($validasiChangePassword['error']) ? $validasiChangePassword['error'] : array();
            echo json_encode(array("status"=>$status,"msg"=>$msg,"error"=>$error));
        }
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/user/admin.php */