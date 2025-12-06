<?php

namespace App\Models\Organigrama\Logic;

class OrgCharManager
{
    public function getHierarchy(): array
    {
        return [
            'CEO' => [
                'CTO' => [
                    'Dev Team Lead' => [
                        'Developer 1',
                        'Developer 2',
                    ],
                ],
                'CFO' => [
                    'Accountant 1',
                    'Accountant 2',
                ],
            ],
        ];
    }
}
