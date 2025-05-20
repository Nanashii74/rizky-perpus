<?php 
namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;

class PeminjamanController extends BaseController
{
    protected $model;
    protected $anggotaModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->model = new PeminjamanModel();
        $this->anggotaModel = new AnggotaModel();
        $this->bukuModel = new BukuModel();
        helper(['form', 'url']);
    }

    public function peminjaman()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        $data = [
            'peminjaman' => $this->model->getPeminjamanWithDetails(),
            'anggota' => $this->anggotaModel->findAll(),
            'buku' => $this->bukuModel->findAll(),
            'jumlah' => $this->model->countAll(),
            'model' => $this->model
        ];
        
        return view('peminjaman', $data);
    }

    public function tambah()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'idanggota' => 'required',
            'idbuku' => 'required',
            'tglpinjam' => 'required',
            'tglkembali' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'idtransaksi' => $this->request->getPost('idtransaksi'),
            'idanggota' => $this->request->getPost('idanggota'),
            'idbuku' => $this->request->getPost('idbuku'),
            'tglpinjam' => $this->request->getPost('tglpinjam'),
            'tglkembali' => $this->request->getPost('tglkembali')
        ];

        try {
            if ($this->model->insert($data)) {
                return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil ditambahkan');
            } else {
                return redirect()->to('/peminjaman')->withInput()->with('error', 'Gagal menambahkan peminjaman');
            }
        } catch (\Exception $e) {
            return redirect()->to('/peminjaman')->withInput()->with('error', 'Terjadi kesalahan sistem');
        }
    }

    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'idanggota' => 'required',
            'idbuku' => 'required',
            'tglpinjam' => 'required',
            'tglkembali' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'idanggota' => $this->request->getPost('idanggota'),
            'idbuku' => $this->request->getPost('idbuku'),
            'tglpinjam' => $this->request->getPost('tglpinjam'),
            'tglkembali' => $this->request->getPost('tglkembali')
        ];

        try {
            if ($this->model->update($id, $data)) {
                return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil diupdate');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupdate peminjaman');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem');
        }
    }

    public function hapus($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/peminjaman')->with('success', 'Peminjaman berhasil dihapus');
        } else {
            return redirect()->to('/peminjaman')->with('error', 'Gagal menghapus peminjaman');
        }
    }
}