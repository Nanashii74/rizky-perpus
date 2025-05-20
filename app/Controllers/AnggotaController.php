<?php 
namespace App\Controllers;

use App\Models\AnggotaModel;

class AnggotaController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AnggotaModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'anggota' => $this->model->orderBy('idanggota', 'DESC')->findAll(),
            'jumlah' => $this->model->countAll(),
            'model' => $this->model
        ];
        
        return view('index', $data);
    }

    public function tambah()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    // Validate input
    $validation = \Config\Services::validation();
    $validation->setRules([
        'nama' => 'required',
        'jeniskelamin' => 'required',
        'alamat' => 'required',
        'status' => 'required'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $data = [
        'idanggota' => $this->request->getPost('idanggota'),
        'nama' => strtoupper($this->request->getPost('nama')),
        'jeniskelamin' => strtoupper($this->request->getPost('jeniskelamin')),
        'alamat' => $this->request->getPost('alamat'),
        'status' => strtoupper($this->request->getPost('status'))
    ];

    try {
        if ($this->model->insert($data)) {
            return redirect()->to('/anggota')->with('success', 'Anggota berhasil ditambahkan');
        } else {
            log_message('error', 'Failed to save member: ' . print_r($this->model->errors(), true));
            return redirect()->to('/anggota')->withInput()->with('error', 'Gagal menambahkan anggota');
        }
    } catch (\Exception $e) {
        log_message('error', 'Error saving member: ' . $e->getMessage());
        return redirect()->to('/anggota')->withInput()->with('error', 'Terjadi kesalahan sistem');
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
        'nama' => 'required',
        'jeniskelamin' => 'required',
        'alamat' => 'required',
        'status' => 'required'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    $data = [
        'nama' => strtoupper($this->request->getPost('nama')),
        'jeniskelamin' => strtoupper($this->request->getPost('jeniskelamin')),
        'alamat' => $this->request->getPost('alamat'),
        'status' => strtoupper($this->request->getPost('status'))
    ];

    try {
        if ($this->model->update($id, $data)) {
            return redirect()->to('/anggota')->with('success', 'Anggota berhasil diupdate');
        } else {
            log_message('error', 'Failed to update member: ' . print_r($this->model->errors(), true));
            return redirect()->back()->withInput()->with('error', 'Gagal mengupdate anggota');
        }
    } catch (\Exception $e) {
        log_message('error', 'Error updating member: ' . $e->getMessage());
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
            return redirect()->to('/anggota')->with('success', 'Anggota berhasil dihapus');
        } else {
            return redirect()->to('/anggota')->with('error', 'Gagal menghapus anggota');
        }
    }
}