<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paspor extends CI_Controller
{
	public function index()
	{
		if ($this->session->userSession) {
			redirect('dasbor');
		}

		$validate = $this->form_validation;
		$this->load->model('User_model', 'userModel');

		$validate->set_rules($this->userModel->rulesLogin());
		if ($validate->run() == false) {
			$data['title'] = 'Login';
			$this->load->view('pages/paspor/loginPage', $data);
		} else {
			$npmUser = $this->input->post('npm', true);
			$passwordUser = $this->input->post('password', true);

			$userData = $this->db->where('npmUser', $npmUser)->get('user')->row();
			if ($userData) {
				if (password_verify($passwordUser, $userData->passwordUser)) {
					$userSession = [
						'idUser' => $userData->idUser,
						'npmUser' => $userData->npmUser,
						'statusUser' => $userData->statusUser
					];
					$this->session->set_userdata('userSession', $userSession);
					$this->session->set_flashdata('alert', 'success|Selamat datang!|Halo, ' . $userData->samaranUser . '.');
					redirect('dasbor');
				} else {
					$this->session->set_flashdata('alert', 'error|Login gagal|Password salah.');
					redirect(current_url());
				}
			} else {
				$this->session->set_flashdata('alert', 'error|Login gagal|User tidak terdaftar.');
				redirect(current_url());
			}
		}
	}

	public function registrasi()
	{
		if ($this->session->userSession) {
			redirect('dasbor');
		}

		$validate = $this->form_validation;
		$this->load->model('User_model', 'userModel');

		$data['prodiList'] = $this->db->where('statusProdi', 1)->get('prodi')->result();

		$validate->set_rules($this->userModel->rulesRegistrasi());
		if ($validate->run() == false) {
			$data['title'] = 'Registrasi Akun';
			$this->load->view('pages/paspor/registrasiPage', $data);
		} else {
			$idProdi = $this->input->post('prodi', true);
			$prodiCheck = $this->db->get_where('prodi', ['idProdi' => $idProdi])->row_array();
			$npmUser = $this->input->post('npm', true);

			if (preg_match("/{$prodiCheck['npmProdi']}/i", $npmUser)) {
				$dataUser = [
					'samaranUser' => ucwords($this->input->post('samaran', true)),
					'npmUser' => $npmUser,
					'passwordUser' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
					'prodiUser' => $idProdi,
					'statusUser' => 1,
					'statusUser' => 0,
					'createdUser' => date('Y-m-d H:i:s', now())
				];

				$this->db->insert('user', $dataUser);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Registrasi berhasil|Login untuk mengakses fitur.');
					redirect('paspor');
				} else {
					$this->session->set_flashdata('alert', 'error|Registrasi gagal|Coba lagi atau hubungi administrator.');
					redirect(current_url());
				}
			} else {
				$this->session->set_flashdata('alert', 'error|NPM tidak sesuai|Coba lagi atau hubungi administrator.');
				redirect(current_url());
			}
		}
	}

	public function logout()
	{
		if ($this->session->userSession) {
			$this->session->unset_userdata('userSession');
			$this->session->unset_userdata('peringkatSession');
			$this->session->set_flashdata('alert', 'success|Logout Berhasil|');
		}
		redirect('paspor');
	}
}
