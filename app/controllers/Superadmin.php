<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$user = $this->session->userSession;
		$alert = 'error|Ayo login|Login dulu untuk melanjutkan';
		if ($user) {
			$this->userSession = $this->db->join('prodi', 'user.prodiUser = prodi.idProdi')->get_where('user', $user)->row();
			if (empty($this->userSession)) {
				$this->session->set_flashdata('alert', $alert);
				redirect('paspor');
				if ($this->userSession->roleUser < 2) {
					show_404();
				}
			}
		} else {
			$this->session->set_flashdata('alert', $alert);
			redirect('paspor');
		}
	}

	public function index()
	{
		$data['title'] = 'You are Superadmin!';
		$data['userSession'] = $this->userSession;
		$data['prodiList'] = $this->db->order_by('namaProdi', 'ASC')->get('prodi')->result();
		$data['userCount'] = $this->db->get('user')->num_rows();
		$data['semesterCount'] = $this->db->get('semester')->num_rows();
		$data['matkulCount'] = $this->db->get('matkul')->num_rows();

		$data['adminList'] = $this->db->join('prodi', 'prodi.idProdi = user.prodiUser')->where('roleUser', 2)->order_by('samaranUser', 'ASC')->get('user')->result();

		$data['pendukungList'] = $this->db->where('prodiPendukung', $this->userSession->prodiUser)->order_by('namaPendukung', 'ASC')->order_by('namaPendukung', 'ASC')->get('pendukung')->result();

		$this->load->view('pages/superadmin/dasborSuperadminPage', $data);
	}

	public function prodi()
	{
		$data['userSession'] = $this->userSession;

		$action = $this->input->get('action', true);
		if (empty($action)) {
			redirect('superadmin');
		}

		$validate = $this->form_validation;

		if ($action == 'delete') {
			$idProdi = $this->input->get('id', true);
			$data['prodiItem'] = $this->db->where('idProdi', $idProdi)->get('prodi')->row();
			if (empty($data['prodiItem'])) {
				show_404();
			}
			$validate->set_rules('check', 'Persetujuan', 'required');
			if ($validate->run() == false) {
				$data['title'] = 'Hapus Prodi';
				$this->load->view('pages/superadmin/prodi/deleteProdiPage', $data);
			} else {
				$this->db->where('idProdi', $idProdi)->delete('prodi');
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil hapus|Hapus prodi ' . $data['prodiItem']->namaProdi . ' berhasil.');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal hapus|Prodi gagal dihapus.');
				}
				redirect('superadmin');
			}
		} elseif ($action == 'tambah') {
			$validate->set_rules('nama', 'Nama Prodi', 'required|trim|min_length[3]|max_length[128]');
			$validate->set_rules('npm', 'NPM Prodi', 'required|numeric|trim|min_length[3]|max_length[128]');
			if ($validate->run() == false) {
				$data['title'] = 'Tambah Prodi';
				$this->load->view('pages/superadmin/prodi/addProdiPage', $data);
			} else {
				$prodiData = [
					'namaProdi' => $this->input->post('nama', true),
					'npmProdi' => $this->input->post('npm', true),
					'statusProdi' => 1
				];
				$this->db->insert('prodi', $prodiData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|' . $prodiData['namaProdi'] . ' berhasil ditambah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal ditambah|');
				}
				redirect('superadmin');
			}
		} elseif ($action == 'edit') {
			$idProdi = $this->input->get('id', true);
			$data['prodiItem'] = $this->db->where('idProdi', $idProdi)->get('prodi')->row();
			if (empty($data['prodiItem'])) {
				show_404();
			}
			$validate->set_rules('nama', 'Nama Prodi', 'required|trim|min_length[3]|max_length[128]');
			$validate->set_rules('npm', 'NPM Prodi', 'required|numeric|trim|min_length[3]|max_length[128]');
			$validate->set_rules('status', 'Status', 'required|numeric|trim|exact_length[1]');
			if ($validate->run() == false) {
				$data['title'] = 'Edit Prodi';
				$this->load->view('pages/superadmin/prodi/editProdiPage', $data);
			} else {
				$prodiData = [
					'namaProdi' => $this->input->post('nama', true),
					'npmProdi' => $this->input->post('npm', true),
					'statusProdi' => $this->input->post('status', true)
				];
				$this->db->where('idProdi', $idProdi)->update('prodi', $prodiData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil diubah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal diubah|');
				}
				redirect('superadmin');
			}
		} else {
			show_404();
		}
	}

	public function admin($page = null, $id = null)
	{
		if (empty($page)) {
			redirect('superadmin');
		}
		$validate = $this->form_validation;

		$data['userSession'] = $this->userSession;

		if ($page == 'tambah') {
			$data['title'] = 'Tambah Admin';

			$validate->set_rules('npm', 'NPM Mahasiswa', 'required|trim|numeric|max_length[16]');
			if ($validate->run() == false) {
				$this->load->view('pages/superadmin/admin/addAdminPage', $data);
			} else {
				$npmUser = $this->input->post('npm', true);
				$userCheck = $this->db->get_where('user', ['npmUser' => $npmUser])->row_array();
				if ($userCheck) {
					$updateUser = [
						'roleUser' => 2
					];
					$this->db->where('npmUser', $npmUser)->update('user', $updateUser);
					if ($this->db->affected_rows() > 0) {
						$this->session->set_flashdata('alert', 'success|Berhasil ditambahkan|');
						redirect('superadmin');
					} else {
						$this->session->set_flashdata('alert', 'error|Gagal dirubah|');
						redirect(current_url());
					}
				} else {
					$this->session->set_flashdata('alert', 'error|User tidak ada|');
					redirect(current_url());
				}
			}
		} elseif ($page == 'delete') {
			$data['userItem'] = $this->db->join('prodi', 'prodi.idProdi = user.prodiUser')->where('idUser', $id)->get('user')->row();
			if (empty($data['userItem']) || $id == $data['userItem']->idUser) {
				redirect('superadmin');
			}
			$validate->set_rules('check', 'Persetujuan', 'required');
			if ($validate->run() == false) {
				$data['title'] = 'Delete Admin';
				$this->load->view('pages/superadmin/admin/deleteAdminPage', $data);
			} else {
				$userCheck = $this->db->get_where('user', ['idUser' => $id])->row_array();
				if ($userCheck) {
					$updateUser = [
						'roleUser' => 0
					];
					$this->db->where('idUser', $id)->update('user', $updateUser);
					if ($this->db->affected_rows() > 0) {
						$this->session->set_flashdata('alert', 'success|Berhasil ditambahkan|');
						redirect('superadmin');
					} else {
						$this->session->set_flashdata('alert', 'error|Gagal dirubah|');
						redirect(current_url());
					}
				} else {
					$this->session->set_flashdata('alert', 'error|User tidak ada|');
					redirect(current_url());
				}
			}
		} else {
			redirect('superadmin');
		}
	}

	// public function matkul()
	// {
	// 	$data['userSession'] = $this->userSession;

	// 	$action = $this->input->get('action', true);
	// 	if (empty($action)) {
	// 		redirect('admin');
	// 	}

	// 	$validate = $this->form_validation;

	// 	if ($action == 'delete') {
	// 		$idMatkul = $this->input->get('id', true);
	// 		$data['matkulItem'] = $this->db->where('idMatkul', $idMatkul)->get('matkul')->row();
	// 		if (empty($data['matkulItem'])) {
	// 			show_404();
	// 		}
	// 		if ($data['matkulItem']->prodiMatkul != $this->userSession->prodiUser) {
	// 			redirect('admin');
	// 		}
	// 		$validate->set_rules('check', 'Persetujuan', 'required');
	// 		if ($validate->run() == false) {
	// 			$data['title'] = 'Hapus Matkul';
	// 			$this->load->view('pages/admin/matkul/deleteMatkulPage', $data);
	// 		} else {
	// 			$this->db->where('idMatkul', $idMatkul)->delete('matkul');
	// 			if ($this->db->affected_rows() > 0) {
	// 				$this->session->set_flashdata('alert', 'success|Berhasil hapus|Hapus matkul ' . $data['matkulItem']->namaMatkul . ' berhasil.');
	// 			} else {
	// 				$this->session->set_flashdata('alert', 'error|Gagal hapus|Matkul gagal dihapus.');
	// 			}
	// 			redirect('admin');
	// 		}
	// 	} elseif ($action == 'tambah') {
	// 		$data['semesterList'] = $this->db->where('statusSemester', 1)->get('semester')->result();

	// 		$validate->set_rules('nama', 'Nama Matkul', 'required|trim|min_length[3]|max_length[128]');
	// 		$validate->set_rules('sks', 'SKS Matkul', 'required|numeric|trim|max_length[11]');
	// 		$validate->set_rules('semester', 'Semester', 'required|trim|numeric|max_length[11]');
	// 		if ($validate->run() == false) {
	// 			$data['title'] = 'Tambah Matkul';
	// 			$this->load->view('pages/admin/matkul/addMatkulPage', $data);
	// 		} else {
	// 			$matkulData = [
	// 				'namaMatkul' => $this->input->post('nama', true),
	// 				'sksMatkul' => $this->input->post('sks', true),
	// 				'semesterMatkul' => $this->input->post('semester', true),
	// 				'prodiMatkul' => $this->userSession->prodiUser,
	// 				'statusMatkul' => 1
	// 			];
	// 			$this->db->insert('matkul', $matkulData);
	// 			if ($this->db->affected_rows() > 0) {
	// 				$this->session->set_flashdata('alert', 'success|Matkul ' . $matkulData['namaMatkul'] . ' Berhasil ditambah|');
	// 			} else {
	// 				$this->session->set_flashdata('alert', 'error|Gagal ditambah|');
	// 			}
	// 			redirect('admin');
	// 		}
	// 	} elseif ($action == 'edit') {
	// 		$data['semesterList'] = $this->db->where('statusSemester', 1)->get('semester')->result();
	// 		$idMatkul = $this->input->get('id', true);
	// 		$data['matkulItem'] = $this->db->where('idMatkul', $idMatkul)->get('matkul')->row();
	// 		if (empty($data['matkulItem'])) {
	// 			show_404();
	// 		}
	// 		if ($data['matkulItem']->prodiMatkul != $this->userSession->prodiUser) {
	// 			redirect('admin');
	// 		}
	// 		$validate->set_rules('nama', 'Nama Matkul', 'required|trim|min_length[3]|max_length[128]');
	// 		$validate->set_rules('semester', 'Semester', 'required|numeric|max_length[11]');
	// 		$validate->set_rules('status', 'Status', 'required|numeric|trim|exact_length[1]');
	// 		if ($validate->run() == false) {
	// 			$data['title'] = 'Edit Matkul';
	// 			$this->load->view('pages/admin/matkul/editMatkulPage', $data);
	// 		} else {
	// 			$matkulData = [
	// 				'namaMatkul' => $this->input->post('nama', true),
	// 				'semesterMatkul' => $this->input->post('semester', true),
	// 				'statusMatkul' => $this->input->post('status', true)
	// 			];
	// 			$this->db->where('idMatkul', $idMatkul)->update('matkul', $matkulData);
	// 			if ($this->db->affected_rows() > 0) {
	// 				$this->session->set_flashdata('alert', 'success|Berhasil diubah|');
	// 			} else {
	// 				$this->session->set_flashdata('alert', 'error|Gagal diubah|');
	// 			}
	// 			redirect('admin');
	// 		}
	// 	} else {
	// 		show_404();
	// 	}
	// }

	// public function pendukung()
	// {
	// 	$data['userSession'] = $this->userSession;

	// 	$action = $this->input->get('action', true);
	// 	if (empty($action)) {
	// 		redirect('admin');
	// 	}

	// 	$validate = $this->form_validation;

	// 	if ($action == 'delete') {
	// 		$idPendukung = $this->input->get('id', true);
	// 		$data['pendukungItem'] = $this->db->where('idPendukung', $idPendukung)->get('pendukung')->row();
	// 		if (empty($data['pendukungItem'])) {
	// 			show_404();
	// 		}
	// 		if ($data['pendukungItem']->prodiPendukung != $this->userSession->prodiUser) {
	// 			redirect('admin');
	// 		}
	// 		$validate->set_rules('check', 'Persetujuan', 'required');
	// 		if ($validate->run() == false) {
	// 			$data['title'] = 'Hapus Parameter Pendukung';
	// 			$this->load->view('pages/admin/datapendukung/deletePendukungPage', $data);
	// 		} else {
	// 			$this->db->where('idPendukung', $idPendukung)->delete('pendukung');
	// 			if ($this->db->affected_rows() > 0) {
	// 				$this->session->set_flashdata('alert', 'success|Berhasil hapus|Hapus parameter ' . $data['pendukungItem']->namaPendukung . ' berhasil.');
	// 			} else {
	// 				$this->session->set_flashdata('alert', 'error|Gagal hapus|Parameter gagal dihapus.');
	// 			}
	// 			redirect('admin');
	// 		}
	// 	} elseif ($action == 'tambah') {
	// 		$validate->set_rules('nama', 'Nama Parameter', 'required|trim|min_length[3]|max_length[128]');
	// 		$validate->set_rules('validasi', 'Jenis Parameter', 'trim|max_length[128]');
	// 		if ($validate->run() == false) {
	// 			$data['title'] = 'Tambah Parameter Pendukung';
	// 			$this->load->view('pages/admin/datapendukung/addPendukungPage', $data);
	// 		} else {
	// 			$pendukungData = [
	// 				'namaPendukung' => $this->input->post('nama', true),
	// 				'validasiPendukung' => $this->input->post('validasi', true),
	// 				'prodiPendukung' => $this->userSession->prodiUser,
	// 				'statusPendukung' => 1
	// 			];
	// 			$this->db->insert('pendukung', $pendukungData);
	// 			if ($this->db->affected_rows() > 0) {
	// 				$this->session->set_flashdata('alert', 'success|Pendukung ' . $pendukungData['namaPendukung'] . ' Berhasil ditambah|');
	// 			} else {
	// 				$this->session->set_flashdata('alert', 'error|Gagal ditambah|');
	// 			}
	// 			redirect('admin');
	// 		}
	// 	} elseif ($action == 'edit') {
	// 		$idPendukung = $this->input->get('id', true);
	// 		$data['pendukungItem'] = $this->db->where('idPendukung', $idPendukung)->get('pendukung')->row();
	// 		if (empty($data['pendukungItem'])) {
	// 			show_404();
	// 		}
	// 		if ($data['pendukungItem']->prodiPendukung != $this->userSession->prodiUser) {
	// 			redirect('admin');
	// 		}
	// 		$validate->set_rules('nama', 'Nama Parameter', 'required|trim|min_length[3]|max_length[128]');
	// 		$validate->set_rules('validasi', 'Jenis Parameter', 'trim|max_length[128]');
	// 		$validate->set_rules('status', 'Status', 'required|numeric|trim|exact_length[1]');
	// 		if ($validate->run() == false) {
	// 			$data['title'] = 'Edit Parameter Pendukung';
	// 			$this->load->view('pages/admin/datapendukung/editPendukungPage', $data);
	// 		} else {
	// 			$pendukungData = [
	// 				'namaPendukung' => $this->input->post('nama', true),
	// 				'validasiPendukung' => $this->input->post('validasi', true),
	// 				'statusPendukung' => $this->input->post('status', true)
	// 			];
	// 			$this->db->where('idPendukung', $idPendukung)->update('pendukung', $pendukungData);
	// 			if ($this->db->affected_rows() > 0) {
	// 				$this->session->set_flashdata('alert', 'success|Berhasil diubah|');
	// 			} else {
	// 				$this->session->set_flashdata('alert', 'error|Gagal diubah|');
	// 			}
	// 			redirect('admin');
	// 		}
	// 	} else {
	// 		show_404();
	// 	}
	// }
}
