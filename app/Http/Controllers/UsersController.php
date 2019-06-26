<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use GuzzleHttp\Client;

class UsersController extends Controller
{
    public function create(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ]);

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        return response()->JSON(['user' => $user], 200);
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = Auth::user();

            // $user['accessToken'] = $user->createToken('Login');
            $guzzle = new Client();

            $response = $guzzle->post('localhost:8000/oauth/token', [
                'headers' => [
                    'client-id' => $request->header('client-id'),
                    'client-secret' => $request->header('client-secret'),
                ],
                'form-params' => [
                    'grant_type' => 'password',
                    'client_id' => $request->header('client-id'),
                    'client_secret' => $request->header('client-secret'),
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'scope' => ''
                ]
            ]);

            $user['accessToken'] = json_decode($response->getBody());

            return response()->JSON(['user' => $user], 200);
        } else {
            return response()->JSON(['error' => 'User Not Found'], 404);
        }
    }
}
