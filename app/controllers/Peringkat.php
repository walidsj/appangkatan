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
		$data['title'] = 'Peringkat Nilai IPK';
		$data['userSession'] = $this->userSession;

		$data['userList'] = $this->db
			->select('idUser, npmUser, samaranUser, SUM((predikat.angkaPredikat * matkul.sksMatkul)) as totalAgregatIp, SUM(matkul.sksMatkul) as totalSks')
			->where('user.prodiUser', $this->userSession->prodiUser)
			->join('ip', 'ip.userIp = user.idUser', 'left')
			->join('predikat', 'predikat.idPredikat = ip.predikatIp', 'left')
			->where('predikat.angkaPredikat IS NOT NULL')
			->join('matkul', 'matkul.idMatkul = ip.matkulIp', 'left')
			->group_by('user.idUser')
			->order_by('totalAgregatIp', 'DESC')
			->get('user')
			->result_array();

		$this->load->view('pages/peringkat/peringkatPage', $data);
	}

	public function kombinasi()
	{
		$data['title'] = 'Peringkat Kombinasi Nilai';
		$data['userSession'] = $this->userSession;

		$userListed = $this->db
			->select('idUser, npmUser, samaranUser, SUM(predikat.angkaPredikat * matkul.sksMatkul) as totalAgregatIp, SUM(matkul.sksMatkul) as totalSks')
			->where('user.prodiUser', $this->userSession->prodiUser)
			->join('ip', 'ip.userIp = user.idUser', 'left')
			->join('predikat', 'predikat.idPredikat = ip.predikatIp', 'left')
			->where('predikat.angkaPredikat IS NOT NULL')
			->join('matkul', 'matkul.idMatkul = ip.matkulIp', 'left')
			->group_by('user.idUser')
			->order_by('totalAgregatIp', 'DESC')
			->get('user')
			->result_array();

		$data['pendukungList'] = $this->db
			->where('prodiPendukung', $this->userSession->prodiUser)
			->where('validasiPendukung', 'numeric')
			->where('proporsiPendukung > 0')
			->order_by('namaPendukung', 'ASC')
			->get('pendukung')
			->result_array();

		$queryTambahan = (string) '';
		$proporsiIp = (float) 100 / 100;
		foreach ($data['pendukungList'] as $pendukung) {
			if ($pendukung['proporsiPendukung'] > 0) {
				$queryTambahan = $queryTambahan . 'SUM(CASE WHEN (parameter.pendukungParameter = ' . $pendukung['idPendukung'] . ') THEN parameter.nilaiParameter ELSE 0 END) as total' . str_replace(' ', '', $pendukung['namaPendukung'] . ',');
			}

			$proporsiIp = (float) $proporsiIp - $pendukung['proporsiPendukung'] / 100;
		}

		$userParametered = $this->db
			->select('user.idUser, SUM(parameter.nilaiParameter * pendukung.proporsiPendukung / 100) as totalParameter, ' . $queryTambahan)
			->where('user.prodiUser', $this->userSession->prodiUser)
			->join('parameter', 'user.idUser = parameter.userParameter', 'left')
			->where('parameter.nilaiParameter IS NOT NULL')
			->join('pendukung', 'pendukung.idPendukung = parameter.pendukungParameter', 'left')
			->group_by('user.idUser')
			->get('user')
			->result_array();

		$data['userList'] = [];
		foreach ($userListed as $user) {
			foreach ($userParametered as $userp) {
				if ($userp['idUser'] == $user['idUser'] && $userp['totalParameter'] > 0) {
					$userp['totalIpk'] = $user['totalAgregatIp'] / $user['totalSks'];
					$userp['totalSkor'] = $userp['totalParameter'] + $user['totalAgregatIp'] * $proporsiIp / $user['totalSks'];
					array_push($data['userList'], array_merge($user, $userp));
				}
			}
		}

		usort($data['userList'], function ($a, $b) {
			if ($a['totalSks'] == $b['totalSks']) {
				return $b['totalSkor'] <=> $a['totalSkor'];
			}
			return $b['totalSks'] <=> $a['totalSks'];
		});

		$this->load->view('pages/peringkat/peringkatProporsiPage', $data);
	}

	public function parameter()
	{
		$idPendukung = $this->input->get('id', true);

		$data['title'] = 'Peringkat Nilai Parameter';
		$data['userSession'] = $this->userSession;

		$data['pendukungList'] = $this->db->where('prodiPendukung', $this->userSession->prodiUser)->order_by('namaPendukung', 'ASC')->order_by('namaPendukung', 'ASC')->get('pendukung')->result();

		if ($idPendukung) {

			$data['userList'] = $this->db
				->select('idUser, npmUser, samaranUser, parameter.nilaiParameter')
				->where('prodiUser', $this->userSession->prodiUser)
				->join('parameter', 'parameter.userParameter = user.idUser', 'left')
				->where('parameter.pendukungParameter', $idPendukung)
				->group_by('user.idUser')
				->order_by('nilaiParameter', 'DESC')
				->get('user')
				->result_array();
		} else {
			$data['userList'] = null;
		}
		$this->load->view('pages/peringkat/peringkatParameterPage', $data);
	}
}
