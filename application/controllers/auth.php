<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library(array('session', 'form_validation', 'upload', ''));
	}

	public function index()
	{
		if (!$this->session->userdata('email')) {

			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');

			if ($this->form_validation->run() == false) {
				$this->load->view('auth/login');
			} else {
				$this->_login();
			}
		} else {
			redirect('user/index');
		}
	}

	public function registration()
	{
		//check validation form
		$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required');
		$this->form_validation->set_rules('nik', 'Nik', 'trim|required');
		$this->form_validation->set_rules('uo', 'Unit Organisasi', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tab_user.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[retype_password]', [
			'matches' => 'Password not match',
			'min_length' => 'Password too short'
		]);
		$this->form_validation->set_rules('retype_password', 'Password', 'required|trim|matches[password]');

		$config['upload_path'] = './form/';
		$config['allowed_types'] = 'xlsx|docx|doc|pdf';
		$config['max_size'] = '1500';

		$this->upload->initialize($config);

		if ($this->form_validation->run() == false) {
			$this->load->view("auth/registration");
		} else {
			if ($this->upload->do_upload('filename')) {
				$uploaded = $this->upload->data();
				$data = [
					'id' => '',
					'name' => htmlspecialchars($this->input->post('fullname', true)),
					'nik' => htmlspecialchars($this->input->post('nik', true)),
					'uo' => htmlspecialchars($this->input->post('uo', true)),
					'email' => htmlspecialchars($this->input->post('email', true)),
					'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
					'password_decrypted' => $this->input->post('password'),
					'role_id' => 0,
					'is_active' => 0,
					'date_created' => time(),
					'filename' => $uploaded['file_name']
				];

				$this->db->insert('tab_user', $data);
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-success" role="alert"> Congratulation, your account has been created. You can login after Mr. Arief approve your account, please contact !</div>'
				);
				redirect('auth/index');
			} else {
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger" role="alert">' . $error . ' </div>'
				);
				$this->load->view("auth/registration");
			}
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('tab_user', ['email' => $email])->row_array();

		if ($user) {
			if ($user['is_active'] == 1) {
				if (password_verify($password, $user['password'])) {
					$data = [
						'id' => $user['id'],
						'email' => $user['email'],
						'role_id' => $user['role_id'],
						'name' => $user['name'],
						'nik' => $user['nik'],
						'uo' => $user['uo'],
						'level' => $user['level']
					];
					$this->session->set_userdata($data);
					redirect('auth/index');
				} else {
					$this->session->set_flashdata(
						'message',
						'<div class="alert alert-danger" role="alert"> Wrong password </div>'
					);
					redirect('auth/index');
				}
			} else {
				$this->session->set_flashdata(
					'message',
					'<div class="alert alert-danger" role="alert"> This email is not active </div>'
				);
				redirect('auth/index');
			}
		} else {
			$this->session->set_flashdata(
				'message',
				'<div class="alert alert-danger" role="alert"> Email is not registered !</div>'
			);
			redirect('auth/index');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('role_id');
		redirect('auth/index');
	}
}
