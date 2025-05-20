<?php

namespace App\Controllers;

use App\Models\AdminModel;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function processLogin()
    {
        $model = new AdminModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $model->where('username', $username)
            ->where('password', $password)
            ->first();

        if ($admin) {
            $session = session();
            $session->set('logged_in', true);
            $session->set('username', $username);

            log_message('debug', 'Session after login: ' . print_r($_SESSION, true));

            return redirect()->to('/index');
        } else {
            $session = session();
            $session->setFlashdata('error', 'Username atau password salah');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->remove('logged_in');
        $session->remove('username');
        $session->destroy();
        return redirect()->to('/login');
    }
}
