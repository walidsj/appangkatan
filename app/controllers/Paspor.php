<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paspor extends CI_Controller
{
	public function index()
	{
		if (!empty($this->session->userSession)) {
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
					$this->session->set_flashdata('alert', 'success|Selamat datang!|Halo, ' . $userData->namaUser . '.');
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
		if (!empty($this->session->userSession)) {
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
			$dataUser = [
				'namaUser' => ucwords($this->input->post('nama', true)),
				'samaranUser' => ucwords($this->input->post('samaran', true)),
				'npmUser' => $this->input->post('npm', true),
				'passwordUser' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
				'prodiUser' => $this->input->post('prodi', true),
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
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('userSession');
		$this->session->set_flashdata('alert', 'success|Logout Berhasil|');
		redirect('paspor');
	}
}
