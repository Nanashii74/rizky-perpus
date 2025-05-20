<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'admin'; // Nama tabel untuk admin
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];
}
