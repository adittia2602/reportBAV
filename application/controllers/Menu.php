<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Basic_mods', 'modul');
    }
    public function index()
    {
        $data['title'] = 'List Menu';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'group' => $this->input->post('group'),
                'menu' => $this->input->post('menu'),
                'urutan' => $this->input->post('urutan'),
            ];
            $this->modul->insertData('menu', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                       New menu added!
                    </div>
                </div>'
            );
            redirect('menu');
        }
    }

    public function excel()
    {
        $data['menu'] = $this->db->get('user_menu')->result_array();

        require(FCPATH . 'assets/extra-libs/PHPExcel-1.8/Classes/PHPExcel.php');
        require(FCPATH . 'assets/extra-libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        $object = new PHPExcel();

        $object->getProperties()->setCreator("Framework Indonesia");
        $object->getProperties()->setLastModifiedby("Framework Indonesia");
        $object->getProperties()->setTitle("User Data");

        $object->setActiveSheetIndex(0);

        $object->getActiveSheet()->setCellValue('A1', 'No');
        $object->getActiveSheet()->setCellValue('B1', 'Group Menu');
        $object->getActiveSheet()->setCellValue('C1', 'Menu');
        $object->getActiveSheet()->setCellValue('D1', 'Urutan');

        $baris = 2;
        $no = 1;

        foreach ($data['menu'] as $m) {
            $object->getActiveSheet()->setCellValue('A' . $baris, $no++);
            $object->getActiveSheet()->setCellValue('B' . $baris, $m['group']);
            $object->getActiveSheet()->setCellValue('C' . $baris, $m['menu']);
            $object->getActiveSheet()->setCellValue('D' . $baris, $m['urutan']);

            $baris++;
        }
        $filename = "Data Userdata" . '.xlsx';

        $object->getActiveSheet()->setTitle("Data User");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $writer->save('php://output');
        exit;
    }

    public function updatemenu($id)
    {
        if (!empty($this->input->post('group'))) {
            $this->db->set('group', $this->input->post('group'));
        }
        if (!empty($this->input->post('menu'))) {
            $this->db->set('menu', $this->input->post('menu'));
        }
        if (!empty($this->input->post('urutan'))) {
            $this->db->set('urutan', $this->input->post('urutan'));
        }

        $this->db->where('id', $id);
        if ($this->db->update('user_menu')) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Edit Menu berhasil. </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            <?= $this->db->_error_message(); ?> </div>');
        }
        redirect('menu');
    }

    public function submenu()
    {
        $data['title'] = 'Submenu';
        $data['bc'] = $this->modul->getBreadcrumb($data['title']);
        $data['user'] = $this->db->get_where('user', ['name' => $this->session->userdata('name')])->row_array();

        // list
        $data['submenu'] = $this->modul->getSubMenu();

        //form
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $active = empty($this->input->post('is_active')) ? '0' : $this->input->post('is_active');
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $active
            ];
            $this->modul->insertData('submenu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            New sub-menu added!</div>');
            redirect('menu/submenu');
        }
    }

    public function updatesubmenu($id)
    {
        if (!empty($this->input->post('title'))) {
            $this->db->set('title', $this->input->post('title'));
        }
        if (!empty($this->input->post('menu_id'))) {
            $this->db->set('menu_id', $this->input->post('menu_id'));
        }
        if (!empty($this->input->post('url'))) {
            $this->db->set('url', $this->input->post('url'));
        }
        if (!empty($this->input->post('icon'))) {
            $this->db->set('icon', $this->input->post('icon'));
        }
        $active = empty($this->input->post('is_active')) ? '0' : $this->input->post('is_active');
        $this->db->set('is_active', $active);

        $this->db->where('id', $id);
        if ($this->db->update('user_sub_menu')) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    Edit submenu berhasil.
                </div>
            </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <?= $this->db->error_message(); ?>
                </div>
            </div>'
            );
        }
        redirect('menu/submenu');
    }

    public function deletesubmenu($id)
    {
        if ($this->modul->deleteData('submenu', $id)) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    Hapus Data berhasil!
                </div>
            </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <?= $this->db->error_message(); ?>
                </div>
            </div>'
            );
        }
        redirect('menu/submenu');
    }
}
