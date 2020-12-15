<?php

class User_model extends CI_Model
{

    public function rulesLogin()
    {
        return [
            [
                'field' => 'npm',
                'label' => 'No. Pokok Mahasiswa',
                'rules' => 'required|trim|numeric|exact_length[10]',
                'errors' => []
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim',
                'errors' => []
            ],
        ];
    }

    public function rulesRegistrasi()
    {
        return [
            [
                'field' => 'nama',
                'label' => 'Nama Asli',
                'rules' => 'required|trim|min_length[4]|max_length[128]',
                'errors' => []
            ],
            [
                'field' => 'samaran',
                'label' => 'Nama Samaran',
                'rules' => 'required|trim|min_length[4]|max_length[128]',
                'errors' => []
            ],
            [
                'field' => 'npm',
                'label' => 'No. Pokok Mahasiswa',
                'rules' => 'required|trim|numeric|exact_length[10]|is_unique[user.npmUser]',
                'errors' => ['is_unique' => 'No. Pokok Mahasiswa telah terdaftar.']
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[5]',
                'errors' => []
            ],
            [
                'field' => 'prodi',
                'label' => 'Program Studi',
                'rules' => 'required|trim|numeric|max_length[11]',
                'errors' => []
            ],
            [
                'field' => 'check',
                'label' => 'Persetujuan',
                'rules' => 'required',
                'errors' => []
            ],
        ];
    }
}
