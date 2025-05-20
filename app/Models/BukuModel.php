<?php 
namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'tbbuku';
    protected $primaryKey = 'idbuku';
    protected $allowedFields = ['idbuku', 'judulbuku', 'kategori', 'pengarang', 'penerbit', 'status'];
    protected $returnType = 'array';
    
    public function generatebookId()
    {
        $last = $this->orderBy('idbuku', 'DESC')->first();
        if ($last) {
            $lastId = (int) substr($last['idbuku'], 2);
            return 'BK' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        }
        return 'BK001';
    }
}