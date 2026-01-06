<?php

namespace App\Models\UserManagement\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\UserManagement\Logic\userManager;



class UserController extends Controller
{
    protected userManager $userManager;
    public function __construct(userManager $userManager){
        $this->userManager = $userManager;
    }

    public function viewUsers() : View
    {
        return view('Users.usuarios');
    }
    public function dataUsers() :JsonResponse{
        return response() ->json(
            $this->userManager->returnUsers()
        );
    }
}
