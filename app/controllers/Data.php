<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends CI_Controller
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

		$data['title'] = 'Data Indeks Prestasi';

		$data['userSession'] = $this->userSession;

		$idSemester = $this->input->get('semester', true);
		$data['matkulList'] = $this->db->where('statusMatkul', 1)->where('prodiMatkul', $this->userSession->prodiUser)->where('semesterMatkul', $idSemester)->join('ip', 'ip.matkulIp = matkul.idMatkul AND ip.userIp = ' . $this->userSession->idUser, 'left')->join('predikat', 'ip.predikatIp = predikat.idPredikat', 'left')->order_by('namaMatkul', 'ASC')->get('matkul')->result();

		// var_dump($data['matkulList']);
		// die;

		foreach ($data['matkulList'] as $matkul) {
			$validate->set_rules($matkul->idMatkul, 'Predikat', 'numeric|trim|max_length[11]');
		}
		$validate->set_rules('check', 'Persetujuan', 'required');
		if ($validate->run() == false) {
			$data['predikatList'] = $this->db->where('statusPredikat', 1)->get('predikat')->result();
			$data['semesterList'] = $this->db->where('statusSemester', 1)->where('prodiSemester', $this->userSession->prodiUser)->order_by('namaSemester', 'ASC')->get('semester')->result();

			$this->load->view('pages/data/dataHomePage', $data);
		} else {
			foreach ($data['matkulList'] as $matkul) {
				$predikatIp = $this->input->post($matkul->idMatkul, true);
				if (!empty($predikatIp)) {
					if (empty($matkul->idIp)) {
						$ipData = [
							'userIp' => $this->userSession->idUser,
							'matkulIp' => $matkul->idMatkul,
							'predikatIp' => $predikatIp,
							'statusIp' => 1
						];
						$this->db->insert('ip', $ipData);
					} else {
						if ($predikatIp != $matkul->predikatIp) {
							$ipData = [
								'predikatIp' => $predikatIp
							];
							$this->db->where('idIp', $matkul->idIp)->where('userIp', $this->userSession->idUser)->update('ip', $ipData);
						}
					}
				}
			}
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('alert', 'success|Berhasil disimpan|');
			} else {
				$this->session->set_flashdata('alert', 'error|Gagal disimpan|');
			}
			redirect('data?semester=' . $idSemester);
		}
	}
}
