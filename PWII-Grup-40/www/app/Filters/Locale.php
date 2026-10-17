<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Locale implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        $requestedLang = $request->getGet('lang');
        if ($requestedLang && in_array($requestedLang, ['en', 'es'])) {
            $session->set('site_lang', $requestedLang);
        }

        $lang = $session->get('site_lang') ?? 'es';

        $request->setLocale($lang);

        Services::language()->setLocale($lang);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}

