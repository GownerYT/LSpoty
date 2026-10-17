<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Services;

class AuthController extends Controller
{
    public function getRegister()
    {
        helper(['form']);
        return view('sign_up');
    }

    public function postRegister()
    {
        helper(['form']);

        $rules = [
            'inputUserName' => 'permit_empty|min_length[3]|max_length[30]|alpha_numeric',
            'inputUserEmail' => 'required|valid_email|is_unique[users.email]|regex_match[/^[a-zA-Z0-9._%+-]+@(students\.salle\.url\.edu|ext\.salle\.url\.edu|salle\.url\.edu)$/]',
            'inputUserPassword' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/]',
            'inputRepeatPassword' => 'required|matches[inputUserPassword]',
            'inputUserProfilePic' => 'permit_empty|uploaded[inputUserProfilePic]|is_image[inputUserProfilePic]|mime_in[inputUserProfilePic,image/jpg,image/jpeg,image/png]'
        ];


        $errors = [
            'inputUserName' => [
                'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de usuario no puede exceder los 30 caracteres.',
                'alpha_numeric' => 'El nombre de usuario solo puede contener letras y números.'
            ],
            'inputUserEmail' => [
                'required' => 'El correo electrónico es obligatorio.',
                'valid_email' => 'La dirección de correo electrónico no es válida.',
                'is_unique' => 'La dirección de correo electrónico ya está registrada.',
                'regex_match' => 'Solo se aceptan correos electrónicos del dominio @students.salle.url.edu, @ext.salle.url.edu o @salle.url.edu.'
            ],
            'inputUserPassword' => [
                'required' => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres.',
                'regex_match' => 'La contraseña debe contener mayúsculas, minúsculas y números.'
            ],
            'inputRepeatPassword' => [
                'required' => 'Es necesario repetir la contraseña.',
                'matches' => 'Las contraseñas no coinciden.'
            ],
            'inputUserProfilePic' => [
                'uploaded' => 'Debes subir una imagen o dejar el campo vacío.',
                'is_image' => 'El archivo debe ser una imagen válida.',
                'mime_in' => 'Solo se permiten imágenes JPG o PNG.'
            ]
        ];

        if ($this->validate($rules, $errors)) {
            $userModel = new UserModel();

            // Nombre de usuario
            $username = $this->request->getPost('inputUserName');
            if (empty($username)) {
                $email = $this->request->getPost('inputUserEmail');
                $username = explode('@', $email)[0];
            }

            // Foto de perfil
            $file = $this->request->getFile('inputUserProfilePic');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/profile-pics', $newName);
                $profilePicPath = 'uploads/profile-pics/' . $newName;
            } else {
                $profilePicPath = 'uploads/profile-pics/defaultUser.png';
            }

            // Insertar usuario
            $userModel->insert([
                'email'       => $this->request->getPost('inputUserEmail'),
                'password'    => password_hash($this->request->getPost('inputUserPassword'), PASSWORD_DEFAULT),
                'username'    => $username,
                'profile_pic' => $profilePicPath
            ]);

            $response = service('response');
            return $response->setCookie('user_email', $this->request->getPost('inputUserEmail'), 60 * 60 * 24 * 30)
                ->redirect('/sign-in');

            //return redirect()->to('/sign-in');
        } else {
            return view('sign_up');
        }
    }

    public function getLogin()
    {
        helper(['form']);
        return view('sign_in');
    }

    public function postLogin()
    {
        helper(['form']);
        $session = Services::session();
        $userModel = new UserModel();

        $email = $this->request->getPost('inputUserEmail');
        $password = $this->request->getPost('inputUserPassword');

        $rules = [
            'inputUserEmail' => 'required|valid_email',
            'inputUserPassword' => 'required'
        ];

        $errors = [
            'inputUserEmail' => [
                'required' => 'La dirección de correo electrónico no es válida.',
                'valid_email' => 'La dirección de correo electrónico no es válida.'
            ],
            'inputUserPassword' => [
                'required' => 'Su correo electrónico y/o contraseña son incorrectos.'
            ]
        ];

        if (!$this->validate($rules, $errors)) {
            return view('sign_in');
        }

        // Buscar usuario en base de datos
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            $validation = Services::validation();
            $validation->setError('inputUserPassword', 'Su correo electrónico y/o contraseña son incorrectos.');
            return view('sign_in');
        }

        // Crear sesión
        $session->set([
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'user_name' => $user['username'],
            'is_logged_in' => true
        ]);

        $response = service('response');
        return $response->setCookie('user_email', $user['email'], 60 * 60 * 24 * 30)
            ->redirect('/home');

    }


    public function logout()
    {
        $session = Services::session();
        $session->destroy();

        return redirect()->to('/');
    }

    public function signUpSuccess()
    {
        return '¡Usuario registrado correctamente!';
    }
}
