<?php

namespace App\Http\Controllers;

use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;

class RedirectToHomeController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $panel = Filament::getCurrentPanel();

        $url = $panel->getUrl(Filament::getTenant());

        if (blank($url)) {
            abort(404);
        }

        return redirect($url);
    }
}
