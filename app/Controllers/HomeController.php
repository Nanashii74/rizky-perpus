<?php 
namespace App\Controllers;

use App\Models\AnggotaModel;

class HomeController extends BaseController
{
    public function index() {
        log_message('debug', 'HomeController accessed');
        $session = session();
        if (!$session->get('logged_in')) {
            log_message('debug', 'Not logged in, redirecting to login');
            return redirect()->to('/login');
        }
        log_message('debug', 'Redirecting to /anggota');
        return redirect()->to('/anggota');
    }
}