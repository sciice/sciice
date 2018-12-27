<?php

namespace Sciice\Http\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('sciice.auth:sciice')->except('login');
    }

    /**
     * {@inheritdoc}
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|min:4',
            'password'        => 'required|string|min:5',
        ]);
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if (config('sciice.many')) {
            return collect(['username', 'email', 'mobile'])->contains(function ($value) use ($request) {
                return $this->guard()->attempt([
                    $value     => $request->input($this->username()),
                    'password' => $request->input('password'),
                ], !blank($request->input('remember')));
            });
        }

        return $this->guard()->attempt($this->credentials($request), !blank($request->input('remember')));
    }

    /**
     * @param Request $request
     * @param         $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function authenticated(Request $request, $user)
    {
        return $this->json(__('登录成功'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = $this->guard()->user();

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->json(__('退出成功'));
    }

    /**
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * @return mixed
     */
    protected function guard()
    {
        return Auth::guard('sciice');
    }
}
