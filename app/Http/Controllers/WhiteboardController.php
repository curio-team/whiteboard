<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;
use App\Announcement;
use Auth;
use Gate;

class WhiteboardController extends Controller
{
    public function index()
    {
        $categories = Category::where('published', true)->with(['users' => function ($q) {
            $q->orderBy('users_categories_pivot.created_at', 'asc');
        }])->get();

        $announcements = Announcement::all();

        return view('layouts.whiteboard')
            ->with('categories', $categories)
            ->with('announcements', $announcements);
    }

    public function signUp(User $user, Category $category)
    {
        if (Gate::allows('edit-own', $user) && $category->published)
        {
            $user->categories()->syncWithoutDetaching($category);
        }
        return redirect()->route('home');
    }

    public function signOff(User $user, Category $category)
    {
        if (Gate::allows('edit-own', $user) && $category->published)
        {
            $user->categories()->detach($category);
        }
        return redirect()->route('home');
    }
}
