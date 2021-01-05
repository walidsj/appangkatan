<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Simulasi extends CI_Controller
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

		$validate = $this->form_validation;

		$data['title'] = 'Simulasi IP';

		$data['userSession'] = $this->userSession;

		$idSemester = $this->input->get('semester', true);

		if ($idSemester) {
			$data['matkulList'] = $this->db->where('statusMatkul', 1)->where('prodiMatkul', $this->userSession->prodiUser)->where('semesterMatkul', $idSemester)->join('nilai', 'nilai.matkulNilai = matkul.idMatkul AND nilai.userNilai = ' . $this->userSession->idUser, 'left')->order_by('namaMatkul', 'ASC')->get('matkul')->result();
		} else {
			$semester = $this->db->where('statusSemester', 2)->where('prodiMatkul', $this->userSession->prodiUser)->order_by('namaSemester', 'DESC')->get_where('semester')->row();
			$data['selectedSemester'] = $semester->idSemester;
			$data['matkulList'] = $this->db->where('statusMatkul', 1)->where('prodiMatkul', $this->userSession->prodiUser)->where('semesterMatkul', $semester->idSemester)->join('nilai', 'nilai.matkulNilai = matkul.idMatkul AND nilai.userNilai = ' . $this->userSession->idUser, 'left')->order_by('namaMatkul', 'ASC')->get('matkul')->result();
		}

		foreach ($data['matkulList'] as $matkul) {
			$validate->set_rules('uts', $matkul->idMatkul, 'Nilai UTS', 'numeric|trim|max_length[11]');
			$validate->set_rules('uas', $matkul->idMatkul, 'Nilai UAS', 'numeric|trim|max_length[11]');
			$validate->set_rules('akt', $matkul->idMatkul, 'Nilai Aktifitas', 'numeric|trim|max_length[11]');
		}
		$validate->set_rules('check', 'Persetujuan', 'required');
		if ($validate->run() == false) {
			$data['predikatList'] = $this->db->where('statusPredikat', 1)->get('predikat')->result();
			$data['semesterList'] = $this->db->where('statusSemester', 2)->where('prodiSemester', $this->userSession->prodiUser)->order_by('namaSemester', 'ASC')->get('semester')->result();

			$this->load->view('pages/simulasi/simulasiHomePage', $data);
		} else {
			foreach ($data['matkulList'] as $matkul) {
				$utsNilai = $this->input->post('uts' . $matkul->idMatkul, true);
				$uasNilai = $this->input->post('uas' . $matkul->idMatkul, true);
				$aktNilai = $this->input->post('akt' . $matkul->idMatkul, true);
				if (empty($matkul->idNilai)) {
					$nilaiData = [
						'userNilai' => $this->userSession->idUser,
						'matkulNilai' => $matkul->idMatkul,
						'utsNilai' => $utsNilai,
						'uasNilai' => $uasNilai,
						'aktNilai' => $aktNilai,
						'statusNilai' => 1
					];
					$this->db->insert('nilai', $nilaiData);
				} else {
					$nilaiData = [
						'utsNilai' => $utsNilai,
						'uasNilai' => $uasNilai,
						'aktNilai' => $aktNilai,
					];
					if (!empty($utsNilai) && $utsNilai != $matkul->utsNilai) {
						$nilaiData['utsNilai'] = $utsNilai;
					}
					if (!empty($uasNilai) && $uasNilai != $matkul->uasNilai) {
						$nilaiData['uasNilai'] = $uasNilai;
					}
					if (!empty($aktNilai) && $aktNilai != $matkul->aktNilai) {
						$nilaiData['aktNilai'] = $aktNilai;
					}

					if (!empty($nilaiData)) {
						$this->db->where('idNilai', $matkul->idNilai)->where('userNilai', $this->userSession->idUser)->update('nilai', $nilaiData);
					}
				}
			}
			$this->session->set_flashdata('alert', 'success|OK|');
			redirect(current_url() . '?semester=' . $idSemester);
		}
	}
}
