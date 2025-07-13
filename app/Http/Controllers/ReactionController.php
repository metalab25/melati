<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function show($token)
    {
        $bukuTamu = BukuTamu::where('survey_token', $token)->firstOrFail();

        return view('website.reaction.form-action', [
            'title'     => "Survey Kepuasan Layanan",
            'token'     => $token,
            'bukuTamu'  => $bukuTamu
        ]);
    }
}
