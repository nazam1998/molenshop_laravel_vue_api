<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Profile;
use App\Models\Shop;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        // Create a new profile for the user
        $profile = new Profile();
        $profile->firstname = $request->firstname;
        $profile->lastname = $request->lastname;
        $filename = Storage::disk('public')->put('profile', $request->picture);
        $profile->picture_path = $filename;
        $profile->user_id = $user->id;
        $profile->save();

        // Create a shop for the user

        $shop = new Shop();
        $shop->user_id = $user->id;
        $shop->name = "Shop de " . $profile->firstname . ' ' . $profile->lastname;
        $shop->save();

        // Create a cart for the user
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->save();

        event(new Registered($user));

        Auth::login($user);

        return response()->json(['message' => 'Votre compte a bien été créé', 'status' => 200]);
    }
}
