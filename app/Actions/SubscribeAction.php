<?php

namespace App\Actions;

use App\Models\PriceEndpoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SubscribeAction
{
    public function execute(Request $request): Model|User
    {
        $email = $request->get('email');
        $name = explode('@', $email)[0];
        $password = Hash::make($request->get('password') ?? Str::random());
        $url = $request->get('url');
        $parsedUrl = parse_url($url);
        $segments = explode('/', $parsedUrl['path']);
        $slug = end($segments);

        $user = User::firstOrCreate(compact('email'), compact('name', 'email', 'password'));
        $priceEndpoint = PriceEndpoint::firstOrCreate(compact('slug'), compact('url', 'slug'));
        $user->price_endpoints()->sync(
            $user->price_endpoints->pluck('id')->add($priceEndpoint->id)->unique()->toArray()
        );

        return $user;
    }
}
