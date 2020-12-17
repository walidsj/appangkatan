<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_pendukung extends CI_Controller
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

		$data['title'] = 'Data Pendukung';

		$data['userSession'] = $this->userSession;

		$data['pendukungList'] = $this->db->join('parameter', 'parameter.pendukungParameter = pendukung.idPendukung AND parameter.userParameter = ' . $this->userSession->idUser, 'left')->where('statusPendukung', 1)->where('prodiPendukung', $this->userSession->prodiUser)->get('pendukung')->result();

		foreach ($data['pendukungList'] as $pendukung) {
			$validate->set_rules($pendukung->idPendukung, $pendukung->namaPendukung, $pendukung->validasiPendukung . '|trim|max_length[128]');
		}
		$validate->set_rules('check', 'Persetujuan', 'required');
		if ($validate->run() == false) {
			$this->load->view('pages/data/dataPendukungPage', $data);
		} else {

			foreach ($data['pendukungList'] as $pendukung) {
				$nilaiPendukung = $this->input->post($pendukung->idPendukung, true);
				if (!empty($nilaiPendukung)) {
					if (empty($pendukung->idParameter)) {
						$parameterData = [
							'userParameter' => $this->userSession->idUser,
							'pendukungParameter' => $pendukung->idPendukung,
							'nilaiParameter' => $nilaiPendukung,
							'statusParameter' => 1
						];
						$this->db->insert('parameter', $parameterData);
					} else {
						if ($nilaiPendukung != $pendukung->nilaiParameter) {
							$parameterData = [
								'nilaiParameter' => $nilaiPendukung
							];
							$this->db->where('idParameter', $pendukung->idParameter)->where('userParameter', $this->userSession->idUser)->update('parameter', $parameterData);
						}
					}
				}
			}
			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('alert', 'success|Berhasil disimpan|');
			} else {
				$this->session->set_flashdata('alert', 'error|Gagal disimpan|');
			}
			redirect(current_url());
		}
	}
}
