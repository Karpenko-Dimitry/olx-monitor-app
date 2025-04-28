<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeAction;
use App\Http\Requests\PriceEndpoint\StoreSubscribeRequest;
use App\Models\PriceEndpoint;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SubscribeController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function create()
    {
        return view('pages.subscribe');
    }

    public function store(StoreSubscribeRequest $request, SubscribeAction $subscribeAction)
    {
        $subscribeAction->execute($request);

        return redirect()->back()->with('success', trans('subscribe.success_message'));
    }
}
