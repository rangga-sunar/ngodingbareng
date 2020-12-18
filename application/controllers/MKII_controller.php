<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MKII_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation', 'upload', 'PHPMailer', 'pdf'));
        $this->load->model(array('MKII_model', 'User_model'));
    }

    public function index()
    {
        if ($this->session->userdata('nik') != '') {

            $data['akses'] = $this->User_model->getAccess();
            $data['list'] = $this->db->get_where('tab_reference', ['program' => substr($this->uri->segment(1), 0, 4)])->result_array();
            $data['change'] = $this->db->get_where('tab_changenum', ['project' => substr($this->uri->segment(1), 0, 4)])->result_array();

            $this->load->view('templates/header');
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/view_MKII', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('auth');
        }
    }

    public function ajax_view()
    {
        $list = $this->MKII_model->get_datatables();
        $data = array();
        $no = $_POST['start'];

        $button = '';

        $program = substr($this->uri->segment(1), 0, 4);

        foreach ($list as $draw) {
            $no++;
            $row = array();

            if ($draw->file_name == '') {
                $button = '<center><a href="javascript:void(0)" class="btn btn-xs btn-success tooltips" data-placement="top" onclick="edit_file(' . "'" . $draw->id . "'" . ')"><i class="fa fa-upload"></i></a>         
                           <a href="javascript:void(0)" class="btn btn-xs btn-teal tooltips" onclick="edit_data(' . "'" . $draw->id . "'" . ')"> <i class="fa fa-edit"></i></a>
                           <a href="javascript:void(0)" class="btn btn-xs btn-bricky tooltips hapus" onclick="delete_data(' . "'" . $draw->id . "'" . ')"><i class="fa fa-times fa fa-white"></i></a></center>';
            } else {
                $button = '<center><a href="javascript:void(0)" class="btn btn-xs btn-teal tooltips" onclick="edit_data(' . "'" . $draw->id . "'" . ')"> <i class="fa fa-edit"></i></a> 
                           <a href="javascript:void(0)" class="btn btn-xs btn-bricky tooltips hapus" onclick="delete_data(' . "'" . $draw->id . "'" . ')"><i class="fa fa-times fa fa-white"></i></a></center>';
            }

            if ($this->session->userdata('level') == 'ADMIN') :
                $row[] = $button;
            else :
                $row[] = '<center><a href="' . base_url("uploads/" . $program . "/viewer.html?file=") . "$draw->file_name" . '"target="_blank" title="click for detail" class="btn btn-xs btn-success tooltips" data-placement="top"><i class="fa clip-eye "></i></a></center>';
            endif;

            $row[] = $no;
            $row[] = $draw->reference;

            if ($draw->file_name == '') {
                $row[] = $draw->drawing;
            } else {
                $row[] = '<a href="' . base_url("uploads/" . $program . "/viewer.html?file=") . "$draw->file_name" . '"target="_blank" title="click for detail">'  .  $draw->drawing . '</a>';
            }
            $row[] = $draw->program;
            $row[] = $draw->title;
            $row[] = $draw->type;
            $row[] = $draw->sheet;
            $row[] = $draw->issue;
            $row[] = $draw->change_no;
            $row[] = $draw->receive;
            $row[] = $draw->release_date;
            $row[] = $draw->obsolete_date;
            $row[] = $draw->effectivity;
            $row[] = $draw->status;
            $row[] = $draw->remark;
            //add html for action
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MKII_model->count_all(),
            "recordsFiltered" => $this->MKII_model->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id)
    {
        $data = $this->MKII_model->get_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add()
    {
        $data = array(
            'id' => '',
            'program' => htmlspecialchars($this->input->post('program', true)),
            'reference' => htmlspecialchars($this->input->post('ref', true)),
            'drawing' => htmlspecialchars($this->input->post('drawing', true)),
            'title' => htmlspecialchars($this->input->post('title', true)),
            'type' => htmlspecialchars($this->input->post('type', true)),
            'issue' => htmlspecialchars($this->input->post('issue', true)),
            'sheet' => htmlspecialchars($this->input->post('sheet', true)),
            'status' => htmlspecialchars($this->input->post('status', true)),
            'change_no' => htmlspecialchars($this->input->post('change', true)),
            'receive' => htmlspecialchars($this->input->post('received', true)),
            'release_date' => htmlspecialchars($this->input->post('release', true)),
            'effectivity' => htmlspecialchars($this->input->post('eff', true) . "-" . $this->input->post('eff_to', true)),
            'remark' => htmlspecialchars($this->input->post('remark', true)),
        );
        if ($this->input->post('drawing') === '') {
            echo json_encode(array("status" => FALSE));
        } else {
            $insert = $this->MKII_model->save($data);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function ajax_update()
    {
        $question = $this->input->post('question');
        if ($question == 'YES') {
            $file_name = "";
        } else {
            $file_name = $this->input->post('filebefore');
        }
        $data = array(
            'program' => htmlspecialchars($this->input->post('program', true)),
            'reference' => htmlspecialchars($this->input->post('ref', true)),
            'drawing' => htmlspecialchars($this->input->post('drawing', true)),
            'title' => htmlspecialchars($this->input->post('title', true)),
            'type' => htmlspecialchars($this->input->post('type', true)),
            'issue' => htmlspecialchars($this->input->post('issue', true)),
            'sheet' => htmlspecialchars($this->input->post('sheet', true)),
            'status' => htmlspecialchars($this->input->post('status', true)),
            'change_no' => htmlspecialchars($this->input->post('change', true)),
            'receive' => htmlspecialchars($this->input->post('received', true)),
            //'release_date' => htmlspecialchars($this->input->post('release', true)),
            'obsolete_date' => htmlspecialchars($this->input->post('obsolete', true)),
            'effectivity' => htmlspecialchars($this->input->post('eff', true) . "-" . $this->input->post('eff_to', true)),
            'remark' => htmlspecialchars($this->input->post('remark', true)),
            'file_name' => $file_name
        );
        $this->MKII_model->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id)
    {
        $this->MKII_model->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
        $this->session->set_flashdata('flash', 'Deleted');
    }

    public function do_upload()
    {
        $config['upload_path'] = "./uploads/";
        $config['allowed_types'] = 'pdf|jpg|png';

        $id = $this->input->post('id');
        $file =  $this->input->post('filename');

        if ($this->upload->do_upload('filename')) {
            $uploaded = $this->upload->data();
            $data = [
                'file_name' => $uploaded[$file]
            ];

            $where = array('id' => $id);
            $result = $this->MKII_model->upload_file($data, $where);

            echo json_encode(array("status" => TRUE));
        }
    }

    public function upload_file()
    {
        $id = $this->input->post('id');
        $program = $this->input->post('program');

        $config['upload_path'] = './uploads/' . $program . '/';
        $config['allowed_types'] = 'pdf|jpg';
        $config['max_size'] = '1000000';

        $this->upload->initialize($config);

        $id = $this->input->post('id');

        if ($this->upload->do_upload('filename')) {
            $uploaded = $this->upload->data();
            $data = [
                'file_name' => $uploaded['file_name']
            ];

            $where = array('id' => $id);
            $this->MKII_model->upload_file($data, $where);

            redirect('MKII_controller');
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . ' </div>'
            );
            redirect('MKII_controller');
        }
    }

    //=====================================START REFERENCE ================================
    public function formref()
    {
        $project = explode("_", $this->uri->segment(1));

        if ($this->session->userdata('nik') != '') {
            $data['ref'] = $this->MKII_model->reference($project[0]);
            $data['akses'] = $this->User_model->getAccess();
            $this->load->view('templates/header');
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/form_ref', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert"> Your session expired !</div>'
            );
            redirect('auth');
        }
    }

    public function saveRef()
    {
        //check validation form
        $this->form_validation->set_rules('ref', 'Reference', 'required|trim');
        $this->form_validation->set_rules('refdate', 'Reference Date', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->formRef();
        } else {

            $data = [
                'id' => '',
                'reference' => htmlspecialchars($this->input->post('ref', true)),
                'program' => htmlspecialchars($this->input->post('program', true)),
                'ref_date' => htmlspecialchars($this->input->post('refdate', true)),
                'createdby' => $this->input->post('createdby'),
                'created_date' => date('Y-m-d H:i:s')
            ];

            $this->MKII_model->saveref($data);
            $this->session->set_flashdata('flash', 'Has been added');
            redirect('user/formref');
        }
    }

    public function RemoveRef()
    {
        $id = $_POST["id"];
        $this->MKII_model->DelRef($id);
        $this->session->set_flashdata('flash', 'Deleted');
        //redirect('user/formref');
    }

    public function upreference()
    {
        $id = $this->input->post('id');
        $program = $this->input->post('program');

        $config['upload_path'] = './uploads/REF_FILE/';
        $config['allowed_types'] = 'xlsx|docx|doc|pdf';
        $config['max_size'] = '1000000';

        $this->upload->initialize($config);

        $id = $this->input->post('id');

        if ($this->upload->do_upload('filename')) {
            $uploaded = $this->upload->data();
            $data = [
                'file_name' => $uploaded['file_name']
            ];

            $where = array('id' => $id);
            $this->MKII_model->uploadref($data, $where);

            redirect('MKII_controller/formref');
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">' .
                    $this->upload->display_errors() . ' </div>'
            );
            redirect('MKII_controller/formref');
        }
    }

    //=====================================END REFERENCE ================================

    //=====================================START CHANGENUM ================================
    public function formchange()
    {
        $project = explode("_", $this->uri->segment(1));

        if ($this->session->userdata('nik') != '') {
            $data['rows'] = $this->MKII_model->changenum($project[0]);
            $data['akses'] = $this->User_model->getAccess();
            $this->load->view('templates/header');
            $this->load->view('templates/navbar', $data);
            $this->load->view('user/form_change', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert"> Your session expired !</div>'
            );
            redirect('auth');
        }
    }

    public function savechange()
    {
        //check validation form
        $this->form_validation->set_rules('rel_date', 'Release Date', 'required|trim');
        $this->form_validation->set_rules('change', 'Change Number', 'required|trim');
        $this->form_validation->set_rules('received', 'Received Date', 'required|trim');
        $this->form_validation->set_rules('program', 'Program', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->formchange();
        } else {

            $data = [
                'change_no' => htmlspecialchars($this->input->post('change', true)),
                'project' => htmlspecialchars($this->input->post('program', true)),
                'effectivity' => htmlspecialchars($this->input->post('eff', true) . "-" . $this->input->post('eff_to', true)),
                'release_date' => htmlspecialchars($this->input->post('rel_date', true)),
                'receive_date' => $this->input->post('received'),
                'created_date' => date('Y-m-d H:i:s')
            ];

            $this->MKII_model->savechangenum($data);
            $this->session->set_flashdata('flash', 'Has been added');
            redirect('MKII_controller/formchange');
        }
    }

    public function removechange()
    {
        $id = $_POST["id"];
        $this->MKII_model->delchangenum($id);
        $this->session->set_flashdata('flash', 'Deleted');
        redirect('MKII_controller/formchange');
    }

    public function uploadchange()
    {
        $id = $this->input->post('id');
        $program = $this->input->post('program');
        $changeno = $this->input->post('changeno');

        $config['upload_path'] = './uploads/CHANGENUM_FILE/';
        $config['allowed_types'] = 'xlsx|docx|doc|pdf';
        $config['max_size'] = '1000000';

        $this->upload->initialize($config);

        $id = $this->input->post('id');

        if ($this->upload->do_upload('filename')) {
            $uploaded = $this->upload->data();
            $data = [
                'file_name_change' => $uploaded['file_name']
            ];

            $where = array('id' => $id);
            $this->MKII_model->uploadchangenum($data, $where);

            $data_drawing = [
                'change_no_file' => $uploaded['file_name']
            ];

            $where = array('change_no' => $changeno);
            $this->MKII_model->updatedrawing($data_drawing, $where);

            redirect('MKII_controller/formchange');
        } else {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger" role="alert">' .
                    $this->upload->display_errors() . ' </div>'
            );
            redirect('MKII_controller/formchange');
        }
    }

    //=====================================END CHANGENUM ================================

}
