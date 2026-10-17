<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserProfileController extends Controller
{
    public function index()
    {
        $session = session();
        $username = $session->get('user_name');

        if (!$username) {
            return redirect()->to('/sign-in');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->to('/sign-in');
        }

        return view('user_profile', ['user' => $user]);
    }

    public function update()
    {
        $session = session();
        $username = $session->get('user_name');

        if (!$username) {
            return redirect()->to('/sign-in');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->to('/sign-in');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'age' => 'required|integer',
            'password' => 'permit_empty|min_length[6]',
            'profile_pic' => 'is_image[profile_pic]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'age' => $this->request->getPost('age'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $profilePic = $this->request->getFile('profile_pic');
        if ($profilePic && $profilePic->isValid() && !$profilePic->hasMoved()) {
            $newName = $profilePic->getRandomName();
            $profilePic->move(WRITEPATH . 'uploads', $newName);
            $data['profile_pic'] = $newName;
        }

        $userModel->update($user['id'], $data);

        return redirect()->to('/profile')->with('success', 'Profile updated successfully.');
    }

    public function delete()
    {
        $session = session();
        $username = $session->get('user_name');

        if (!$username) {
            return redirect()->to('/sign-in');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user) {
            $userModel->delete($user['id']);
        }

        $session->destroy();
        return redirect()->to('/');
    }
}