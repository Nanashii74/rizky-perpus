<?php 
namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'tbanggota';
    protected $primaryKey = 'idanggota';
    protected $allowedFields = ['idanggota', 'nama', 'jeniskelamin', 'alamat', 'status'];
    protected $returnType = 'array';
    
    public function generateMemberId()
    {
        $last = $this->orderBy('idanggota', 'DESC')->first();
        if ($last) {
            $lastId = (int) substr($last['idanggota'], 2);
            return 'AG' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        }
        return 'AG001';
    }
}