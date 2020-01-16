<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');

    }
    public function index()
    {
        $data['title'] = 'Account';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['editing'] = 'd-none';
        $data['col'] = 'col-lg-7';


        $data['role'] = $this->db->get_where('user_role', ['id' =>  $data['user']['role_id']])->row_array();
        
        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('account/index', $data);
        $this->load->view('templates/footer'); // untuk memanggil template footer
    }

    public function edit()
    {
        $data['title'] = 'Account';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();
        $data['role'] = $this->db->get_where('user_role', ['id' =>  $data['user']['role_id']])->row_array();
        $data['editing'] = 'd-block';
        $data['col'] = 'col-lg-5';


        $this->form_validation->set_rules('email','Email','trim|valid_email');
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'trim|min_length[4]|matches[password2]',
            $rules = array('min_length' => 'Password too short', 'matches' => 'Password dont match!!')
        );
        $this->form_validation->set_rules('password2', 'Password', 'trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Edit Account';
            $this->load->view('templates/header', $data); // untuk memanggil template header
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('account/index', $data);
            $this->load->view('templates/footer'); // untuk memanggil template footer
        }
        else {
            if (!empty($this->input->post('fullname'))){
                $this->db->set('fullname',$this->input->post('fullname'));
            }
            if (!empty($this->input->post('email'))){
                $this->db->set('email',$this->input->post('email'));
            }
            if (!empty($this->input->post('password1'))){
                $this->db->set('password', password_hash($this->input->post('password1'), PASSWORD_DEFAULT));
            }
            $this->db->where('id', $data['user']['id']);
            $this->db->update('user');
            $this->session->set_flashdata('message',
            '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    Data profile anda berhasil diupdate
                </div>
            </div>');
            redirect('account');
        }
    }
}
