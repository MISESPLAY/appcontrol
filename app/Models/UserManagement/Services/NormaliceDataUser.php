<?php

namespace App\Models\UserManagement\Services;

class NormaliceDataUser
{
    public function normalizeUsers($user) :array
    {
        $datacleaned = [];
        $userRaw = $user ?? null ;
        foreach ($userRaw as $employee) {
            $id =  $employee['id'];
            $fullName = $employee['FirstName'] . ' ' . $employee['LastName'];
            $email = $employee['email'];
            $datacleaned[] = [
                'id' => $id,
                'Full Name' => $fullName,
                'email' => $email,
            ];
        }

          return $datacleaned;


    }

}
