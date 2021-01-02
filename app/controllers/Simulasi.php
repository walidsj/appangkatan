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
		$data['title'] = 'Prediksi Nilai';
		$data['userSession'] = $this->userSession;

		$this->load->view('pages/extra/comingsoonPage', $data);
	}
}
