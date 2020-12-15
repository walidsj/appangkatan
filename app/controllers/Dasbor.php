<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dasbor extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userSession;
		$alert = 'error|Ayo login|Login dulu untuk melanjutkan';
		if ($user) {
			$this->userSession = $this->db->join('prodi', 'prodi.idProdi = user.prodiUser')->get_where('user', $user)->row();
			if (empty($this->userSession)) {
				$this->session->set_flashdata('alert', $alert);
				redirect('paspor');
			}
		} else {
			$this->session->set_flashdata('alert', $alert);
			redirect('paspor');
		}
	}
	public function index()
	{
		$data['title'] = 'Selamat Datang';
		$data['userSession'] = $this->userSession;

		$data['semesterList'] = $this->db->where('statusSemester', 1)->where('prodiSemester', $this->userSession->prodiUser)->order_by('namaSemester', 'ASC')->get('semester')->result();
		$data['matkulList'] = $this->db->where('statusMatkul', 1)->where('prodiMatkul', $this->userSession->prodiUser)->join('ip', 'ip.matkulIp = matkul.idMatkul AND ip.userIp = ' . $this->userSession->idUser, 'left')->join('predikat', 'ip.predikatIp = predikat.idPredikat', 'left')->order_by('namaMatkul', 'ASC')->get('matkul')->result();

		$this->load->view('pages/dasbor/homePage', $data);
	}

	public function profil()
	{
		$data['userSession'] = $this->userSession;
		$data['title'] = $data['userSession']->samaranUser;

		$this->load->view('pages/dasbor/profilePage', $data);
	}

	public function ganti_password()
	{
		$validate = $this->form_validation;

		$data['userSession'] = $this->userSession;
		$data['title'] = $data['userSession']->samaranUser;

		$validate->set_rules('password', 'Password Lama', 'required|trim');
		$validate->set_rules('newPassword', 'Password Baru', 'required|trim|min_length[5]|max_length[64]');
		if ($validate->run() == false) {
			$this->load->view('pages/dasbor/passwordPage', $data);
		} else {
			$passwordOld = $this->input->post('password', true);
			$passwordNew = $this->input->post('newPassword', true);
			if (password_verify($passwordOld, $this->userSession->passwordUser)) {
				$this->db->where('idUser', $this->userSession->idUser)->update('user', ['passwordUser' => password_hash($passwordNew, PASSWORD_DEFAULT)]);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Penggantian berhasil|Password berhasil diganti.');
					redirect('dasbor');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal ganti|Coba lagi atau hubungi administrator.');
					redirect(current_url());
				}
			} else {
				$this->session->set_flashdata('alert', 'error|Gagal ganti|Password lama salah.');
				redirect(current_url());
			}
		}
	}
}
