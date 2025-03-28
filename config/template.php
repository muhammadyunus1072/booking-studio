<?php

return [
    'title' => env('APP_NAME', 'Booking System'),
    'subtitle' => 'Self Studio - Photobox - Pas Foto',

    'logo_auth' => 'files/images/logo.png',
    'logo_auth_background' => 'white',

    'logo_panel' => 'files/images/logo_long.png',
    'logo_panel_background' => 'white',
    
    'admin_role' => env('ADMIN_ROLE', 'Admin'),

    'registration_route' => 'register',
    'registration_default_role' => 'Member',

    'forgot_password_route' => 'password.request',
    'reset_password_route' => 'password.reset',

    // 'email_verification_route' => 'verification.index',
    'email_verification_route' => '',
    'email_verification_delay_time' => 30,

    'email_verify_route' => 'verification.verify',

    'profile_route' => 'profile',
    'profile_image' => 'assets/media/avatars/profile.png',

    'menu' => [
        [
            'text' => 'Dashboard',
            'route'  => 'dashboard.index',
            'icon' => 'ki-duotone ki-element-11',
        ],
        [
            'text' => 'Master Data',
            'icon' => 'ki-duotone ki-shield-tick',
            'submenu' => [
                [
                    'text' => 'Studio',
                    'route' => 'studio.index',
                    'icon_color' => 'success',
                ],
                [
                    'text' => 'Produk',
                    'route' => 'product.index',
                    'icon_color' => 'success',
                ],
                [
                    'text' => 'Metode Pembayaran',
                    'route' => 'payment_method.index',
                    'icon_color' => 'success',
                ],
            ],
        ],
        [
            // 'id' => 'menu_admin'
            'text' => 'Transaksi',
            'icon' => 'ki-duotone ki-shield-tick',
            'submenu' => [
                [
                    'text' => 'Management Transaksi',
                    'route' => 'transaction.index',
                    'icon_color' => 'success',
                ],
            ],
        ],
        [
            // 'id' => 'menu_admin'
            'text' => 'Laporan',
            'icon' => 'ki-duotone ki-shield-tick',
            'submenu' => [
                [
                    'text' => 'Laporan - Transaksi',
                    'route' => 'transaction_report.index',
                    'icon_color' => 'success',
                ],
            ],
        ],
        [
            // 'id' => 'menu_admin'
            'text' => 'Layanan',
            'icon' => 'ki-duotone ki-shield-tick',
            'submenu' => [
                [
                    'text' => 'Scanner QR',
                    'route' => 'scanner.index',
                    'icon_color' => 'success',
                ],
            ],
        ],
        [
            // 'id' => 'menu_admin'
            'text' => 'Admin',
            'icon' => 'ki-duotone ki-shield-tick',
            'submenu' => [
                [
                    'text' => 'Pengguna',
                    'route' => 'user.index',
                    'icon_color' => 'success',
                ],
                [
                    'text' => 'Jabatan',
                    'route' => 'role.index',
                    'icon_color' => 'primary',
                ],
                [
                    'text' => 'Akses',
                    'route' => 'permission.index',
                    'icon_color' => 'primary',
                ],
            ],
        ],
    ],
];
