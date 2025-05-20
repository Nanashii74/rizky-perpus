<?php 
namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'tbtransaksi';
    protected $primaryKey = 'idtransaksi';
    protected $allowedFields = ['idtransaksi', 'idanggota', 'idbuku', 'tglpinjam', 'tglkembali'];
    protected $returnType = 'array';
    
    public function generateTransactionId()
    {
        $last = $this->orderBy('idtransaksi', 'DESC')->first();
        if ($last) {
            $lastId = (int) substr($last['idtransaksi'], 2);
            return 'TR' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        }
        return 'TR001';
    }

    public function getPeminjamanWithDetails()
    {
        return $this->db->table('tbtransaksi t')
            ->select('t.*, a.nama, b.judulbuku')
            ->join('tbanggota a', 't.idanggota = a.idanggota')
            ->join('tbbuku b', 't.idbuku = b.idbuku')
            ->get()
            ->getResultArray();
    }
}