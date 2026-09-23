<?php

namespace Modules\MasjidMediaHelpCenter\Http\Controllers;

use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function __construct()
    {
        $this->middleware('mm.public_locale');
    }

    public function index()
    {
        $locale = app()->getLocale();
        $links = config('masjidmediahelpcenter.links.'.$locale, config('masjidmediahelpcenter.links.id'));

        return view('masjidmediahelpcenter::landing', [
            'links' => $links,
        ]);
    }
}
