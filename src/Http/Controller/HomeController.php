<?php

namespace Sciice\Http\Controller;

use Illuminate\Http\Request;
use Sciice\Foundation\Sciice;
use Sciice\Http\Service\AuthorizeService;
use Sciice\Http\Service\RoleService;
use Sciice\Http\Service\SciiceService;

class HomeController extends Controller
{
    /**
     * @var \Sciice\Contract\Service|SciiceService
     */
    private $sciiceService;

    /**
     * @var \Sciice\Contract\Service|RoleService
     */
    private $roleService;

    /**
     * @var \Sciice\Contract\Service|AuthorizeService
     */
    private $authorizeService;

    /**
     * @var Sciice
     */
    private $sciice;

    /**
     * HomeController constructor.
     *
     * @param \Sciice\Contract\Service|SciiceService    $sciiceService
     * @param \Sciice\Contract\Service|RoleService      $roleService
     * @param \Sciice\Contract\Service|AuthorizeService $authorizeService
     * @param Sciice                                    $sciice
     */
    public function __construct(
        SciiceService $sciiceService,
        RoleService $roleService,
        AuthorizeService $authorizeService,
        Sciice $sciice
    ) {
        $this->sciiceService = $sciiceService;
        $this->roleService = $roleService;
        $this->authorizeService = $authorizeService;
        $this->sciice = $sciice;

        $this->middleware('sciice.auth:sciice');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $authorize = $request->user('sciice')->getAllPermissions()->pluck('name')->toArray();

        return response()->json([
            'user'      => $this->sciiceService->resource($request->user('sciice')->id),
            'menu'      => $this->sciice->menu()->filterMenu($authorize)->formatMenu()->toArray(),
            'auth'      => $this->authorizeService->resources(),
            'role'      => $this->roleService->resources(),
            'authorize' => $authorize,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function avatar(Request $request)
    {
        return $this->sciiceService
            ->avatarImageUpload($request)
            ->resource($request->user('sciice')->id);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function user(Request $request)
    {
        return $this->sciiceService
            ->updateUserInfo($request)
            ->resource($request->user('sciice')->id);
    }
}
