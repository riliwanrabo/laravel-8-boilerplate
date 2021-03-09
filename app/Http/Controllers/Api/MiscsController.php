<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiscsController extends Controller
{
    public function siteHealth()
    {
        return $this->helper()->responder([], 200, 'We are fine out here!');
    }
}
