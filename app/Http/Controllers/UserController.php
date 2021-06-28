<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the relevant view to update user information.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        return view('auth.update-profile-information')->with('user', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        if (Auth::user()) {
            Auth::user()->delete();
            return redirect()->route("home")->with('status', 'Your profile has been deleted.');
        } else {
            return redirect()->back()->with('error', 'An error occurred.');
        }
    }
}
