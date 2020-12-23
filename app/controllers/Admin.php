<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
				if ($this->userSession->roleUser < 1) {
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
		$data['title'] = 'Dasbor Admin';
		$data['userSession'] = $this->userSession;
		$data['semesterList'] = $this->db->where('prodiSemester', $this->userSession->prodiUser)->order_by('namaSemester', 'ASC')->get('semester')->result();
		$data['matkulList'] = $this->db->join('semester', 'matkul.semesterMatkul = semester.idSemester')->where('prodiMatkul', $this->userSession->prodiUser)->order_by('namaSemester', 'ASC')->order_by('namaMatkul', 'ASC')->get('matkul')->result();
		$data['userList'] = $this->db->where('prodiUser', $this->userSession->prodiUser)->get('user')->result();

		$data['pendukungList'] = $this->db->where('prodiPendukung', $this->userSession->prodiUser)->order_by('namaPendukung', 'ASC')->order_by('namaPendukung', 'ASC')->get('pendukung')->result();

		$this->load->view('pages/admin/dasborAdminPage', $data);
	}

	public function semester()
	{
		$data['userSession'] = $this->userSession;

		$action = $this->input->get('action', true);
		if (empty($action)) {
			redirect('admin');
		}

		$validate = $this->form_validation;

		if ($action == 'delete') {
			$idSemester = $this->input->get('id', true);
			$data['semesterItem'] = $this->db->where('idSemester', $idSemester)->get('semester')->row();
			if (empty($data['semesterItem'])) {
				show_404();
			}
			if ($data['semesterItem']->prodiSemester != $this->userSession->prodiUser) {
				redirect('admin');
			}
			$validate->set_rules('check', 'Persetujuan', 'required');
			if ($validate->run() == false) {
				$data['title'] = 'Hapus Semester';
				$this->load->view('pages/admin/semester/deleteSemesterPage', $data);
			} else {
				$this->db->where('idSemester', $idSemester)->delete('semester');
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil hapus|Hapus semester ' . $data['semesterItem']->namaSemester . ' berhasil.');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal hapus|Semester gagal dihapus.');
				}
				redirect('admin');
			}
		} elseif ($action == 'tambah') {
			$validate->set_rules('nama', 'Nama Semester', 'required|trim|min_length[3]|max_length[128]');
			if ($validate->run() == false) {
				$data['title'] = 'Tambah Semester';
				$this->load->view('pages/admin/semester/addSemesterPage', $data);
			} else {
				$semesterData = [
					'namaSemester' => $this->input->post('nama', true),
					'prodiSemester' => $this->userSession->prodiUser,
					'statusSemester' => 1
				];
				$this->db->insert('semester', $semesterData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|' . $semesterData['namaSemester'] . ' berhasil ditambah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal ditambah|');
				}
				redirect('admin');
			}
		} elseif ($action == 'edit') {
			$idSemester = $this->input->get('id', true);
			$data['semesterItem'] = $this->db->where('idSemester', $idSemester)->get('semester')->row();
			if (empty($data['semesterItem'])) {
				show_404();
			}
			if ($data['semesterItem']->prodiSemester != $this->userSession->prodiUser) {
				redirect('admin');
			}
			$validate->set_rules('nama', 'Nama Semester', 'required|trim|min_length[3]|max_length[128]');
			$validate->set_rules('status', 'Status', 'required|numeric|trim|exact_length[1]');
			if ($validate->run() == false) {
				$data['title'] = 'Edit Semester';
				$this->load->view('pages/admin/semester/editSemesterPage', $data);
			} else {
				$semesterData = [
					'namaSemester' => $this->input->post('nama', true),
					'statusSemester' => $this->input->post('status', true)
				];
				$this->db->where('idSemester', $idSemester)->update('semester', $semesterData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil diubah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal diubah|');
				}
				redirect('admin');
			}
		} else {
			show_404();
		}
	}

	public function matkul()
	{
		$data['userSession'] = $this->userSession;

		$action = $this->input->get('action', true);
		if (empty($action)) {
			redirect('admin');
		}

		$validate = $this->form_validation;

		if ($action == 'delete') {
			$idMatkul = $this->input->get('id', true);
			$data['matkulItem'] = $this->db->where('idMatkul', $idMatkul)->get('matkul')->row();
			if (empty($data['matkulItem'])) {
				show_404();
			}
			if ($data['matkulItem']->prodiMatkul != $this->userSession->prodiUser) {
				redirect('admin');
			}
			$validate->set_rules('check', 'Persetujuan', 'required');
			if ($validate->run() == false) {
				$data['title'] = 'Hapus Matkul';
				$this->load->view('pages/admin/matkul/deleteMatkulPage', $data);
			} else {
				$this->db->where('idMatkul', $idMatkul)->delete('matkul');
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil hapus|Hapus matkul ' . $data['matkulItem']->namaMatkul . ' berhasil.');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal hapus|Matkul gagal dihapus.');
				}
				redirect('admin');
			}
		} elseif ($action == 'tambah') {
			$data['semesterList'] = $this->db->where('statusSemester', 1)->get('semester')->result();

			$validate->set_rules('nama', 'Nama Matkul', 'required|trim|min_length[3]|max_length[128]');
			$validate->set_rules('sks', 'SKS Matkul', 'required|numeric|trim|max_length[11]');
			$validate->set_rules('semester', 'Semester', 'required|trim|numeric|max_length[11]');
			if ($validate->run() == false) {
				$data['title'] = 'Tambah Matkul';
				$this->load->view('pages/admin/matkul/addMatkulPage', $data);
			} else {
				$matkulData = [
					'namaMatkul' => $this->input->post('nama', true),
					'sksMatkul' => $this->input->post('sks', true),
					'semesterMatkul' => $this->input->post('semester', true),
					'prodiMatkul' => $this->userSession->prodiUser,
					'statusMatkul' => 1
				];
				$this->db->insert('matkul', $matkulData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Matkul ' . $matkulData['namaMatkul'] . ' Berhasil ditambah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal ditambah|');
				}
				redirect('admin');
			}
		} elseif ($action == 'edit') {
			$data['semesterList'] = $this->db->where('statusSemester', 1)->get('semester')->result();
			$idMatkul = $this->input->get('id', true);
			$data['matkulItem'] = $this->db->where('idMatkul', $idMatkul)->get('matkul')->row();
			if (empty($data['matkulItem'])) {
				show_404();
			}
			if ($data['matkulItem']->prodiMatkul != $this->userSession->prodiUser) {
				redirect('admin');
			}
			$validate->set_rules('nama', 'Nama Matkul', 'required|trim|min_length[3]|max_length[128]');
			$validate->set_rules('semester', 'Semester', 'required|numeric|max_length[11]');
			$validate->set_rules('status', 'Status', 'required|numeric|trim|exact_length[1]');
			if ($validate->run() == false) {
				$data['title'] = 'Edit Matkul';
				$this->load->view('pages/admin/matkul/editMatkulPage', $data);
			} else {
				$matkulData = [
					'namaMatkul' => $this->input->post('nama', true),
					'semesterMatkul' => $this->input->post('semester', true),
					'statusMatkul' => $this->input->post('status', true)
				];
				$this->db->where('idMatkul', $idMatkul)->update('matkul', $matkulData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil diubah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal diubah|');
				}
				redirect('admin');
			}
		} else {
			show_404();
		}
	}

	public function pendukung()
	{
		$data['userSession'] = $this->userSession;

		$action = $this->input->get('action', true);
		if (empty($action)) {
			redirect('admin');
		}

		$validate = $this->form_validation;

		if ($action == 'delete') {
			$idPendukung = $this->input->get('id', true);
			$data['pendukungItem'] = $this->db->where('idPendukung', $idPendukung)->get('pendukung')->row();
			if (empty($data['pendukungItem'])) {
				show_404();
			}
			if ($data['pendukungItem']->prodiPendukung != $this->userSession->prodiUser) {
				redirect('admin');
			}
			$validate->set_rules('check', 'Persetujuan', 'required');
			if ($validate->run() == false) {
				$data['title'] = 'Hapus Parameter Pendukung';
				$this->load->view('pages/admin/datapendukung/deletePendukungPage', $data);
			} else {
				$this->db->where('idPendukung', $idPendukung)->delete('pendukung');
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil hapus|Hapus parameter ' . $data['pendukungItem']->namaPendukung . ' berhasil.');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal hapus|Parameter gagal dihapus.');
				}
				redirect('admin');
			}
		} elseif ($action == 'tambah') {
			$validate->set_rules('nama', 'Nama Parameter', 'required|trim|min_length[3]|max_length[128]');
			$validate->set_rules('proporsi', 'Proporsi Parameter', 'required|numeric|trim|max_length[11]');
			$validate->set_rules('validasi', 'Jenis Parameter', 'trim|max_length[128]');
			if ($validate->run() == false) {
				$data['title'] = 'Tambah Parameter Pendukung';
				$this->load->view('pages/admin/datapendukung/addPendukungPage', $data);
			} else {
				$pendukungData = [
					'namaPendukung' => $this->input->post('nama', true),
					'validasiPendukung' => $this->input->post('validasi', true),
					'proporsiPendukung' => $this->input->post('proporsi', true),
					'prodiPendukung' => $this->userSession->prodiUser,
					'statusPendukung' => 1
				];
				$this->db->insert('pendukung', $pendukungData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Pendukung ' . $pendukungData['namaPendukung'] . ' Berhasil ditambah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal ditambah|');
				}
				redirect('admin');
			}
		} elseif ($action == 'edit') {
			$idPendukung = $this->input->get('id', true);
			$data['pendukungItem'] = $this->db->where('idPendukung', $idPendukung)->get('pendukung')->row();
			if (empty($data['pendukungItem'])) {
				show_404();
			}
			if ($data['pendukungItem']->prodiPendukung != $this->userSession->prodiUser) {
				redirect('admin');
			}
			$validate->set_rules('nama', 'Nama Parameter', 'required|trim|min_length[3]|max_length[128]');
			$validate->set_rules('proporsi', 'Proporsi Parameter', 'required|numeric|trim|max_length[11]');
			$validate->set_rules('validasi', 'Jenis Parameter', 'trim|max_length[128]');
			$validate->set_rules('status', 'Status', 'required|numeric|trim|exact_length[1]');
			if ($validate->run() == false) {
				$data['title'] = 'Edit Parameter Pendukung';
				$this->load->view('pages/admin/datapendukung/editPendukungPage', $data);
			} else {
				$pendukungData = [
					'namaPendukung' => $this->input->post('nama', true),
					'validasiPendukung' => $this->input->post('validasi', true),
					'proporsiPendukung' => $this->input->post('proporsi', true),
					'statusPendukung' => $this->input->post('status', true)
				];
				$this->db->where('idPendukung', $idPendukung)->update('pendukung', $pendukungData);
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('alert', 'success|Berhasil diubah|');
				} else {
					$this->session->set_flashdata('alert', 'error|Gagal diubah|');
				}
				redirect('admin');
			}
		} else {
			show_404();
		}
	}
}
