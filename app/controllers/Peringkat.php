<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peringkat extends CI_Controller
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
		$data['title'] = 'Peringkat Nilai (' . $this->userSession->namaProdi . ')';
		$data['userSession'] = $this->userSession;

		$pagination = $this->input->get('by', true);

		if ($pagination == '') {
			$data['userList'] = $this->db
				->select('idUser, npmUser, samaranUser, SUM((predikat.angkaPredikat * matkul.sksMatkul)) as totalAgregatIp, SUM(matkul.sksMatkul) as totalSks')
				->where('prodiUser', $this->userSession->prodiUser)
				->join('ip', 'ip.userIp = user.idUser', 'left')
				->join('predikat', 'predikat.idPredikat = ip.predikatIp', 'left')
				->join('matkul', 'matkul.idMatkul = ip.matkulIp', 'left')
				->group_by('user.idUser')
				->order_by('totalAgregatIp', 'DESC')
				->get('user')
				->result_array();

			$data['matkul'] = $this->db->select('SUM(sksMatkul) as totalSks')->where('prodiMatkul', $this->userSession->prodiUser)->get('matkul')->row_array();

			$this->load->view('pages/peringkat/peringkatPage', $data);
		} elseif ($pagination = 'parameter') {

			$idPendukung = $this->input->get('parameter', true);

			$data['pendukungList'] = $this->db->where('prodiPendukung', $this->userSession->prodiUser)->order_by('namaPendukung', 'ASC')->order_by('namaPendukung', 'ASC')->get('pendukung')->result();


			$data['userList'] = $this->db
				->select('idUser, npmUser, samaranUser, parameter.nilaiParameter')
				->where('prodiUser', $this->userSession->prodiUser)
				->join('parameter', 'parameter.userParameter = user.idUser', 'left')
				->where('parameter.pendukungParameter', $idPendukung)
				->group_by('user.idUser')
				->order_by('nilaiParameter', 'DESC')
				->get('user')
				->result_array();

			$this->load->view('pages/peringkat/peringkatParameterPage', $data);
		}
	}
}
