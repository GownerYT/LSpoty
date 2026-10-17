<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userEmail = $session->get('user_email');

        if (!$userEmail) {
            return redirect()->to('/sign-in')->with('error', 'Please Sign In');
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $userEmail)->first();

        if (!$user) {
            return redirect()->to('/sign-in')->with('error', 'Please Sign In');
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
