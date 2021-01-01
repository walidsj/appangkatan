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

		$data['semesterList'] = $this->db
			->select('semester.*, COUNT(matkul.idMatkul) as totalMatkul, COUNT(ip.idIp) as terisiMatkul, SUM(predikat.angkaPredikat * matkul.sksMatkul) as agregatIp, SUM(matkul.sksMatkul) as totalSks, SUM(CASE WHEN (ip.idIp IS NOT NULL) THEN matkul.sksMatkul ELSE 0 END) as terisiSks')
			->where('statusSemester', 1)
			->where('prodiSemester', $this->userSession->prodiUser)
			->join('matkul', 'matkul.semesterMatkul = semester.idSemester', 'left')
			->join('ip', 'ip.matkulIp = matkul.idMatkul AND ip.userIp = ' . $this->userSession->idUser, 'left')
			->join('predikat', 'ip.predikatIp = predikat.idPredikat', 'left')
			->group_by('semester.namaSemester')
			->order_by('namaSemester', 'ASC')
			->get('semester')
			->result();

		$data['terisiMatkul'] = 0;
		$data['terisiSks'] = 0;
		$data['totalMatkul'] = 0;
		$data['totalSks'] = 0;
		$data['agregatIp'] = 0;
		foreach ($data['semesterList'] as $semesterItem) {
			$data['totalMatkul'] = $data['totalMatkul'] + $semesterItem->totalMatkul;
			$data['terisiMatkul'] = $data['terisiMatkul'] + $semesterItem->terisiMatkul;
			$data['totalSks'] = $data['totalSks'] + $semesterItem->totalSks;
			$data['terisiSks'] = $data['terisiSks'] + $semesterItem->terisiSks;
			$data['agregatIp'] = $data['agregatIp'] + $semesterItem->agregatIp;
		}

		if ($data['terisiSks'] > 0) {
			$data['totalIpk'] = $data['agregatIp'] / $data['terisiSks'];
		} else {
			$data['totalIpk'] = 0;
		}

		$this->load->view('pages/dasbor/homePage2', $data);
	}

	public function profil()
	{
		$data['userSession'] = $this->userSession;
		$data['title'] = $data['userSession']->samaranUser;

		$validate = $this->form_validation;

		$validate->set_rules('samaran', 'Nama Samaran baru', 'required|trim|min_length[4]|max_length[128]|is_unique[user.samaranUser]', ['is_unique' => 'Nama samaran telah dipakai, coba yang lain.']);
		if ($validate->run() == false) {
			$this->load->view('pages/dasbor/profilePage', $data);
		} else {
			$samaranUser = $this->input->post('samaran', true);
			$this->db->where('idUser', $this->userSession->idUser)->update('user', ['samaranUser' => $samaranUser]);
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('alert', 'success|Ganti Profil berhasil|Profil berhasil diganti.');
				redirect(current_url());
			} else {
				$this->session->set_flashdata('alert', 'error|Gagal ganti|Coba lagi atau hubungi administrator.');
				redirect(current_url());
			}
		}
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
