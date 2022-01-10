<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Inspiring;

class MiscellaneousController extends Controller
{
    public function getAQuote()
    {
        $quote = Inspiring::quote();

        return response()->success("Successful", ['quote' => $quote]);
    }
}
