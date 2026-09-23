<?php

return [
    'name' => 'MasjidMediaHelpCenter',

    // Mailbox that receives contact-form conversations.
    'mailbox_id' => env('HELPCENTER_MAILBOX_ID'),

    // Support email shown when the mailbox is unavailable.
    'support_email' => env('HELPCENTER_SUPPORT_EMAIL', 'support@masjidmedia.id'),

    // Public repo of this module (AGPL-3.0 §13). The footer link is hidden
    // while this is empty.
    'source_url' => env('HELPCENTER_SOURCE_URL'),

    // Card / link targets, per locale.
    'links' => [
        'id' => [
            'mobile_guide' => 'https://docs.masjidmedia.id/mobile-app/01-pemasangan/02-persyaratan-aplikasi.html',
            'tv_guide'     => 'https://docs.masjidmedia.id/tv-app/01-pemasangan/02-persyaratan-aplikasi.html',
            'docs'         => 'https://docs.masjidmedia.id/',
            'privacy'      => 'https://masjidmedia.id/privacy',
            'terms'        => 'https://masjidmedia.id/terms',
            'delete_account' => 'https://app.masjidmedia.id/delete-account',
            'website'      => 'https://masjidmedia.id',
        ],
        'en' => [
            'mobile_guide' => 'https://docs.masjidmedia.id/en/mobile-app/01-pemasangan/02-persyaratan-aplikasi.html',
            'tv_guide'     => 'https://docs.masjidmedia.id/en/tv-app/01-pemasangan/02-persyaratan-aplikasi.html',
            'docs'         => 'https://docs.masjidmedia.id/en/',
            'privacy'      => 'https://masjidmedia.id/privacy?lang=en',
            'terms'        => 'https://masjidmedia.id/terms?lang=en',
            'delete_account' => 'https://app.masjidmedia.id/delete-account',
            'website'      => 'https://masjidmedia.id/?lang=en',
        ],
    ],
];
