<?php

namespace App\Controllers;

use Myth\Auth\Controllers\AuthController as MythAuthController;

class AuthController extends MythAuthController
{
    public function login()
    {
        if ($this->auth->check()) {
            $redirectURL = $this->adminRedirectUrl();
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        $_SESSION['redirect_url'] = $this->adminRedirectUrl();

        return $this->_render($this->config->views['login'], ['config' => $this->config]);
    }

    public function attemptLogin()
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if ($this->config->validFields === ['email']) {
            $rules['login'] .= '|valid_email';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');
        $type     = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! $this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
            return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
        }

        if ($this->auth->user()->force_pass_reset === true) {
            return redirect()->to(route_to('reset-password') . '?token=' . $this->auth->user()->reset_hash)->withCookies();
        }

        $redirectURL = $this->adminRedirectUrl();
        unset($_SESSION['redirect_url']);

        return redirect()->to($redirectURL)->withCookies()->with('message', lang('Auth.loginSuccess'));
    }

    private function adminRedirectUrl(): string
    {
        $redirectURL = session('redirect_url');
        $path        = trim(parse_url($redirectURL ?? '', PHP_URL_PATH) ?? '', '/');

        if ($redirectURL && ($path === 'admin/post' || str_starts_with($path, 'admin/post/'))) {
            return $redirectURL;
        }

        return site_url('admin/post');
    }
}
