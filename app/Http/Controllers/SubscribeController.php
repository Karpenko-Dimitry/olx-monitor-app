<?php

namespace App\Http\Controllers;

use App\Actions\SubscribeAction;
use App\Http\Requests\PriceEndpoint\StoreSubscribeRequest;
use App\Jobs\ParsePriceJob;
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
        $priceEndPoint = $subscribeAction->execute($request);
        dispatch(new ParsePriceJob($priceEndPoint->id));

        return redirect()->back()->with('success', trans('subscribe.success_message'));
    }
}
