<?php

return [
    // ================= admin menu =================
    'main' => [
        'M1' => [
            'name' => '회원 관리',
            'route' => null,
            'param' => [],
            'url' => 'javascript:void(0);',
            'dev' => false,
            'pass' => false,
        ],

        'mail' => [
            'name' => '메일 관리',
            'route' => null,
            'param' => [],
            'url' => 'javascript:void(0);',
            'dev' => false,
            'pass' => false,
        ],

        'stat' => [
            'name' => '접속 통계',
            'route' => null,
            'param' => [],
            'url' => 'javascript:void(0);',
            'dev' => false,
            'pass' => false,
        ],
    ],

    'sub' => [
        'M1' => [
            'S1' => [
                'name' => '회원 관리',
                'route' => 'member',
                'param' => [],
                'url' => null,
                'dev' => false,
                'pass' => false,
            ]
        ],

        'mail' => [
            'S1' => [
                'name' => '메일 관리',
                'route' => 'mail',
                'param' => [],
                'url' => null,
                'dev' => false,
                'pass' => false,
            ],

            'S2' => [
                'name' => '주소록 관리',
                'route' => 'mail.address',
                'param' => [],
                'url' => null,
                'dev' => false,
                'pass' => false,
            ],
        ],

        'stat' => [
            'S1' => [
                'name' => '접속 통계',
                'route' => 'stat',
                'param' => [],
                'url' => null,
                'dev' => false,
                'pass' => false,
            ],

            'S2' => [
                'name' => '접속 경로',
                'route' => 'stat.referer',
                'param' => [],
                'url' => null,
                'dev' => false,
                'pass' => false,
            ],
        ],
    ]
];
