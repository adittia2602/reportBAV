<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');
    }
    public function index()
    {
        $data['title'] = 'List Users';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $data['users'] = $this->modul->getUsers();
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data); // untuk memanggil template header
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer'); // untuk memanggil template footer

    }

    public function updateuser($id){
        if (!empty($this->input->post('name'))){
            $this->db->set('name',$this->input->post('name'));
        }
        if (!empty($this->input->post('email'))){
            $this->db->set('email',$this->input->post('email'));
        }
        if (!empty($this->input->post('role'))){
            $this->db->set('role_id',$this->input->post('role'));
        }
        if (!empty($this->input->post('password'))){
            $this->db->set('password',password_hash($this->input->post('password'), PASSWORD_DEFAULT));
        }
        $active = empty($this->input->post('is_active')) ? '0' : $this->input->post('is_active');
        $this->db->set('is_active',$active);

        $this->db->where('id', $id);

        if ($this->db->update('user')) {
            $this->session->set_flashdata('message',
            '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                Edit user berhasil.
                </div>
            </div>');
        } else {
            $this->session->set_flashdata('message',
            '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                    <?= $this->db->_error_message(); ?>
                </div>
            </div>');
        }

        redirect('users/index');
    }

    public function role() {
        $data['title'] = 'Group Roles';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

        $this->form_validation->set_rules('role', 'role', 'required|is_unique[user_role.role]',
                $rules = array('is_unique' => 'nama Role sudah tersedia.')
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('users/role', $data);
            $this->load->view('templates/footer');
        } else {
            $data =  $this->input->post('role');
            $this->modul->insertData('role', $data);
            $this->session->set_flashdata('message',
            '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                   <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    New Roles added!
                </div>
            </div>');
            redirect('users/role');
        }
    }

    public function deleteRole($id) {
        if ($this->modul->deleteData('role',$id)) {
            $this->session->set_flashdata('message',
            '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    Hapus Data berhasil!
                </div>
            </div>');

        } else {
            $this->session->set_flashdata('message',
            '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                    <?= $this->db->_error_message(); ?>
                </div>
            </div>');
        }
        redirect('users/role');

    }

    public function roleaccess($role_id) {

        $data['title'] = 'Group Roles';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id !=', 3);
        $this->db->where('id !=', 4);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/accessrole', $data);
        $this->load->view('templates/footer');
    }

    public function changeaccess() {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        $data = ['role_id' => $role_id, 'menu_id' => $menu_id];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message',
        '<div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                Access Changed!
            </div>
        </div>');
    }
}
