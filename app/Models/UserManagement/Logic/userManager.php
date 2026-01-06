<?php

namespace App\Models\UserManagement\Logic;
use App\Models\Users\Persistence\Eloquent\Repository\UserRepository;
use App\Models\UserManagement\Services\NormaliceDataUser;

class userManager
{
    protected UserRepository $userRepository;
    protected NormaliceDataUser $NormaliceDataUser;

    public function __construct(UserRepository $userRepository , NormaliceDataUser  $NormaliceDataUser ){
        $this->userRepository = $userRepository;
        $this->NormaliceDataUser = $NormaliceDataUser;

    }



    public function returnUsers()
    {
        $user = $this->userRepository->employees();
        if (!empty($user)) {
            return $this->NormaliceDataUser->normalizeUsers($user);
        } else {
            return "Sin datos" ;
        }


    }

}
