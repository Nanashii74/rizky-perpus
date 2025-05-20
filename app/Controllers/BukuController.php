<?php

namespace App\Controllers;

use App\Models\BukuModel;

class BukuController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new BukuModel();
        helper(['form', 'url']);
    }

    public function buku()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data = [
            'buku' => $this->model->orderBy('idbuku', 'DESC')->findAll(),
            'jumlah' => $this->model->countAll(),
            'model' => $this->model
        ];

        return view('buku', $data);
    }

    public function tambah()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judulbuku' => 'required',
            'kategori' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'status' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'idbuku' => $this->request->getPost('idbuku'),
            'judulbuku' => strtoupper($this->request->getPost('judulbuku')),
            'kategori' => strtoupper($this->request->getPost('kategori')),
            'pengarang' => strtoupper($this->request->getPost('pengarang')),
            'penerbit' => strtoupper($this->request->getPost('penerbit')),
            'status' => strtoupper($this->request->getPost('status'))
        ];

        try {
            if ($this->model->insert($data)) {
                return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan');
            } else {
                log_message('error', 'Failed to save Book: ' . print_r($this->model->errors(), true));
                return redirect()->to('/buku')->withInput()->with('error', 'Gagal menambahkan buku');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error saving member: ' . $e->getMessage());
            return redirect()->to('/buku')->withInput()->with('error', 'Terjadi kesalahan sistem');
        }
    }
    // Edit member
    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judulbuku' => 'required',
            'kategori' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'status' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            
            'judulbuku' => strtoupper($this->request->getPost('judulbuku')),
            'kategori' => strtoupper($this->request->getPost('kategori')),
            'pengarang' => strtoupper($this->request->getPost('pengarang')),
            'penerbit' => strtoupper($this->request->getPost('penerbit')),
            'status' => strtoupper($this->request->getPost('status'))
        ];

        try {
            if ($this->model->update($id, $data)) {
                return redirect()->to('/buku')->with('success', 'Buku berhasil diupdate');
            } else {
                log_message('error', 'Failed to update Book: ' . print_r($this->model->errors(), true));
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate Buku');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error updating Book: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem');
        }
    }

    // Delete member
    public function hapus($id)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/buku')->with('success', 'Bukuberhasil dihapus');
        } else {
            return redirect()->to('/buku')->with('error', 'Gagal menghapus Buku');
        }
    }
}
