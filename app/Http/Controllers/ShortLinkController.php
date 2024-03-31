<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use App\Services\ShortLinkService;
use Illuminate\Http\JsonResponse;

class ShortLinkController extends Controller
{
    public function __construct(
        protected ShortLinkService $shortLinkService,
    ){}


    public function createForm()
    {
        return view('create_form');
    }


    public function create(CreateLinkRequest $request)
    {
        try {
            $link = $this->shortLinkService->createShortLink($request->validated());
            session()->flash('success', 'Short link created successfully! Your link is ' .  config('APP_URL') . route('link.redirect', ['shortLink' => $link->shortLink]));
        } catch (\Exception $e) {
            session()->flash('error', 'Something has happened');
        }

        return redirect()->route('link.form');
    }

    public function redirect(string $shortLink)
    {
        $originalLink = $this->shortLinkService->getAndRedirect($shortLink);
        if (!$originalLink){
            abort(404);
        }
        return redirect($originalLink);
    }
}
