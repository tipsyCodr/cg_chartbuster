<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function privacyPolicy()
    {
        return view('pages.legal.privacy');
    }

    public function termsAndConditions()
    {
        return view('pages.legal.terms');
    }

    public function cookiePolicy()
    {
        return view('pages.legal.cookie');
    }

    public function copyrightPolicy()
    {
        return view('pages.legal.copyright');
    }

    public function communityGuidelines()
    {
        return view('pages.legal.community-guidelines');
    }

    public function contentModeration()
    {
        return view('pages.legal.content-moderation');
    }

    public function disclaimer()
    {
        return view('pages.legal.disclaimer');
    }

    public function aboutUs()
    {
        return view('pages.about');
    }
}
