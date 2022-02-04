<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muser extends CI_Model {

    function cekLogin(){
        $pwd = $this->input->post('pwd',TRUE);
        $username = $this->input->post('username',TRUE);
        $this->db->where('username', $username);
        $this->db->where('aes_decrypt(`password`, `key_password`) = '.$this->db->escape($pwd).' ' );
        $this->db->where('status_user="aktif"');
        $query=$this->db->get('sys_user');
        if ($query->num_rows()!=null) {         
            $data=$query->row_array();                  
            $this->session->set_userdata("user",$data);        
            return array("status"=>200,"msg"=>"Berhasil Login");
        }else{
            return array("status"=>500,"msg"=>"Data User tidak ditemukan");         
        }
    }
    function validasi($id_admin=0){
        $status=200;
        $msg="";
        // $function_lib=$this->load->library('function_lib');        
        
        // exit();
        $username = $this->input->post('username',TRUE);        
        $email = $this->input->post('email',TRUE);        
        if ($id_admin==0) {            
        $id_admin = isset($this->session->userdata('admin')['id_admin']) ? $this->session->userdata('admin')['id_admin'] : null;
        }
        // dapatkan data untuk edit
        $usernameOri = $this->function_lib->get_one('username','admin','id_admin="'.$id_admin.'"');        
        $emailOri = $this->function_lib->get_one('email','admin','id_admin="'.$id_admin.'"');                
        $is_unique = ($username != $usernameOri)? '|is_unique[admin.username]':'';
        $is_uniqueEmail = ($email != $emailOri)? '|is_unique[admin.email]':'';
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required'.$is_unique,
             array(                
                'is_unique'     => 'Username sudah terpakai.'
            )
        );        
        $this->form_validation->set_rules('email', 'Email', 'required'.$is_uniqueEmail,
            array(                
                'is_unique'     => 'Email sudah terpakai.'
            )
        );  
        // validasi tambah
        if ($this->input->post('tambah')) {
            $this->form_validation->set_rules('status', 'Status', 'required',
                array(                
                    'required'     => '%s masih kosong.'
                )
            );  
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]',
                array(                
                    'required'     => '%s masih kosong.',
                    'min_length'   => '%s harus lebih dari 5 karakter.'
                )
            );  
            $this->form_validation->set_rules('conf_password', 'Konfirmasi Password', 'required|matches[password]',
                array(                
                    'required'     => '%s masih kosong.',
                    'matches'      => '%s tidak cocok'
                )
            );  
        }      
        if ($this->form_validation->run() == TRUE) {
            $status=200;
            $msg="Berhasil";
            $error = array(
                "username" => form_error('username'),
                "email" => form_error('email'),
                "status" => form_error('status'),
                "password" => form_error('password'),
                "conf_password" => form_error('conf_password'),
            );
        } else {
            $status=500;
            $msg=validation_errors(' ',' ');
            $error = array(
                "username" => form_error('username'),
                "email" => form_error('email'),
                "status" => form_error('status'),
                "password" => form_error('password'),
                "conf_password" => form_error('conf_password'),
            );
        }
        return array("status"=>$status,"msg"=>$msg,"error"=>$error);        
    }
    function changePassword($id_admin=0){
        $status = 500;
        $msg = "";
        $error = array();
        $old_password = $this->input->post('old_password',TRUE);        
        $new_password = $this->input->post('new_password',TRUE);        
        $repeat_password = $this->input->post('repeat_password',TRUE);        

        $this->load->library('form_validation');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|matches[repeat_password]');  
        if (!empty($this->session->userdata('admin'))) {
            $oldPasswordHash = hash('sha512',$old_password . config_item('encryption_key'));        
            $this->form_validation->set_rules('old_password', 'Password Lama', 'required');  
        }
        $this->form_validation->set_rules('repeat_password', 'Konfirmasi Password', 'required');  
        if ($this->form_validation->run() == TRUE) {            
                if (!empty($this->session->userdata('admin'))) {
                    $id_admin = $this->session->userdata('admin')['id_admin'];                    
                    $id_admin = $this->function_lib->get_one('id_admin','admin','password='.$this->db->escape($oldPasswordHash).' AND id_admin='.$this->db->escape($id_admin).'');                    
                }

                if (floatval($id_admin) != 0) {     
                    $columnUpdate = array(
                        "password" => hash('sha512',$new_password . config_item('encryption_key')),   
                    );                    
                    $this->db->where('id_admin', $id_admin);
                    $this->db->update('admin', $columnUpdate);
                    $status=200;
                    $msg="Berhasil mengubah password";
                }else{
                    $status = 500;
                    $msg = "Password lama tidak sesuai";
                    $error = array(                
                        "old_password" => '<p>Password lama tidak sesuai</p>',
                        "new_password" => form_error('new_password'),
                        "repeat_password" => form_error('repeat_password'),
                    );
                }
            

        } else {
            $status=500;
            $msg="Gagal, ".validation_errors(' ',' ');
            $error = array(                
                "new_password" => form_error('new_password'),
                "old_password" => form_error('old_password'),
                "repeat_password" => form_error('repeat_password'),
            );
        }            
        return array("status"=>$status,"msg"=>$msg,"error"=>$error);            
    }

    function editProfil(){
        $username = $this->input->post('username',TRUE);        
        $email = $this->input->post('email',TRUE);        
        $id_opd_admin = $this->input->post('id_opd_admin',TRUE);        
        $idAdmin = $this->session->userdata('admin')['id_admin'];                
        $validasi = $this->validasi();      
        $status = 500;
        $msg = "";
        if ($validasi['status']==200) {
            // cek opd apakah sudah dimiliki admin lain
            $cekIdOpd = $this->function_lib->get_one('id_opd_admin', 'admin', 'id_opd_admin IN (SELECT id_opd FROM opd WHERE status_opd!="deleted") AND id_opd_admin = '.$this->db->escape($id_opd_admin).' AND id_admin !='.$this->db->escape($idAdmin).' ');
            if (!empty($cekIdOpd)) {
                $status = 500;
                $msg = "OPD ini sudah digunakan oleh admin lain, silahkan pilih OPD lain atau hubungi Super Admin untuk mengubah OPD";
                
            }else{
                $columnUpdate = array(
                    "email"=> $email,
                    "username"=> $username,
                    "id_opd_admin" => $id_opd_admin
                );
                $this->db->where('id_admin="'.$idAdmin.'"');
                $this->db->update('admin', $columnUpdate);
                $status = 200;
                $msg = "Berhasil Update";
            }
        }else{
            $status = $validasi['status'];
            $msg = $validasi['msg'];
        }
        return array("status"=>$status,"msg"=>$msg);
    }

    function getData(){
        $params = isset($_POST) ? $_POST : array();
        $params['table'] = 'admin';

        $username=$this->input->get('username',true);
        $email=$this->input->get('email',true);        
        $status=$this->input->get('status',true);        
                
        $params['select'] = "
            *
        ";
        $params['join'] = "
        ";
        $params['where'] = "1 AND status!='deleted'";
      
        if(trim($username)!='')
        {
            $params['where'].=' AND username LIKE "%'.$username.'%"';
        }        
        if(trim($email)!='')
        {
            $params['where'].=' AND email LIKE "%'.$email.'%"';
        }
        if(trim($status)!='')
        {
            $params['where'].=' AND status LIKE "%'.$status.'%"';
        }        
          
        
        $params['order_by'] = "
            id_admin DESC
        ";
   
        
        $query = $this->function_lib->db_query_execution($params);
        $total = $this->function_lib->db_query_execution($params, true);        
        return array("query"=>$query,"total"=>$total);
    }
    function delete($id_admin){
        $cek = $this->function_lib->get_one('id_admin','admin','id_admin="'.$id_admin.'"');
        if (trim($cek)!="") {           
            $columnUpdate = array(
                "status"=>"deleted"
            );
            $this->db->where('id_admin', $id_admin);
            $this->db->update('admin', $columnUpdate);
        }
        return array("status"=>200,"msg"=>"Berhasil menghapus");
    }
    function edit($id_admin){
        $username = $this->input->post('username',TRUE);        
        $email = $this->input->post('email',TRUE);        
        $status_post = $this->input->post('status',TRUE);        
        $status = $this->input->post('status',TRUE);        
        $status_post = trim($status)!=""?$status:"pending";        
        $validasi = $this->validasi($id_admin);      
        $status = 500;
        $msg = "";
        $error = isset($validasi['error']) ? $validasi['error'] : array();
        if ($validasi['status']==200) {
            $columnUpdate = array(
                "email"=> $email,
                "username"=> $username,                
                "status"=> $status_post,
            );
            $this->db->where('id_admin="'.$id_admin.'"');
            $this->db->update('admin', $columnUpdate);
            $status = 200;
            $msg = "Berhasil Update";
        }else{
            $status = $validasi['status'];
            $msg = $validasi['msg'];
        }
        return array("status"=>$status,"msg"=>$msg,"error"=>$error);
    }
    function tambah(){
        $username = $this->input->post('username',TRUE);        
        $email = $this->input->post('email',TRUE);        
        $password= $this->input->post('password',TRUE);        
        $status_post = $this->input->post('status',TRUE);                
        $status_post = trim($status_post)!=""?$status_post:"pending";        
        $validasi = $this->validasi();      
        $status = 500;
        $msg = "";
        $error = isset($validasi['error']) ? $validasi['error'] : array();
        if ($validasi['status']==200) {
            $hashPassword = hash('sha512', $password . config_item('encryption_key'));     
            $columnInsert = array(
                "email"=> $email,
                "username"=> $username,
                "password"=> $hashPassword,
                "status"=> $status_post,                
            );
            
            $this->db->insert('admin', $columnInsert);
            $status = 200;
            $msg = "Berhasil Menambah Admin";
        }else{
            $status = $validasi['status'];
            $msg = $validasi['msg'];
        }
        return array("status"=>$status,"msg"=>$msg,"error"=>$error);
    }
  
    public function lupass(){
        $this->load->library('form_validation');                    
        $data['status']=500;                                    
        $data['msg']="Gagal silahkan coba lagi";
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        if ($this->form_validation->run() == TRUE) {                
            $email = $this->input->post('email', TRUE);
            $email = $this->security->sanitize_filename($email);
            $cek_email = $this->function_lib->get_one('email','admin','status="aktif" AND email='.$this->db->escape($email).'');
            if (!empty($cek_email)) {
                $exp_datetime = date("Y-m-d H:i:s",strtotime('+10 hours'));
                $jam_sekarang = date("Y-m-d H:i:s",strtotime($exp_datetime));
                $menit_lalu = date("Y-m-d H:i:s",strtotime('+590 minutes'));
                // BETWEEN '2016-01-23 00:00:00' AND '2016-01-24 00:00:00'
                // cek hitung batasan limit request forget password range 10 menit, limit 5 request
                $jumlah_request = $this->function_lib->get_one('count(id_forget_password)','forget_password','email='.$this->db->escape($email).' AND jenis_user="admin" AND exp_datetime BETWEEN '.$this->db->escape($menit_lalu).' AND '.$this->db->escape($jam_sekarang).'');                 
                if (intval($jumlah_request)<5) {
                    $this->insertKode($email);
                    $data['status']=200;                                    
                    $data['msg']="Email telah dikirim, silahkan cek email untuk mengubah password"; 
                }else{                  
                    $data['status'] = 500;                                  
                    $data['msg'] = "Anda terlalu banyak melakukan request perubahan password, silahkan tunggu 10 menit lagi.";  
                }
            }else{
                $data['status']=500;                                    
                $data['msg']="Pengguna dengan email tersebut tidak ditemukan."  ;
            }
        } else {
            $data['status']=500;                                    
            $data['msg']="Gagal silahkan coba lagi";
        }       
        return $data;       
    }
    function insertKode($email){
        $id_user = $this->function_lib->get_one('id_admin','admin','email='.$this->db->escape($email).'');
        $configKey = "3mai1f0rg3t";
        $exp_datetime = date("Y-m-d H:i:s",strtotime('+10 hours'));
        $token = hash('sha512', $email . $configKey . $exp_datetime);
        $this->db->set('is_active','0');
        $this->db->where('email', $email);
        $this->db->where('jenis_user', "kolektor");
        $this->db->update('forget_password');
        $columnInsert = array(
            "email" => $email,
            "jenis_user" => "admin",
            "id_user" => $id_user,
            "token" => $token,
            "exp_datetime" => $exp_datetime
        );
        $insert = $this->db->insert('forget_password', $columnInsert);
        if ($insert) {
            $this->load->model('Mmail');
            $data_email['token']=$token;
            $data_email['base_url'] = base_url();
            $message = $this->load->view('template_email_forget_password', $data_email, TRUE);          
            $this->Mmail->kirim_email($email,"Koperasi Artakita","Permintaan Perubahaan Password",$message);
        }
        
    }
}

/* End of file Madmin.php */
/* Location: ./application/models/Madmin.php */