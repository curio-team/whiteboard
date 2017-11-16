<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use Auth;
use Gate;

class WhiteboardController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('layouts.whiteboard', compact('categories'));
    }

    public function signUp(User $user, Category $category)
    {
        if (Gate::allows('edit-own', $user))
        {
            $user->categories()->syncWithoutDetaching($category);
        }
        return redirect()->route('home');
    }

    public function signOff(User $user, Category $category)
    {
        if (Gate::allows('edit-own', $user))
        {
            $user->categories()->detach($category);
        }
        return redirect()->route('home');
    }
}
