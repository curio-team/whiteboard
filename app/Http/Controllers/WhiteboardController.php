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
    
    private $pusher;

    public function __construct()
    {
        $this->pusher = new \Pusher\Pusher(
            \Config::get('broadcasting.connections.pusher.key'),
            \Config::get('broadcasting.connections.pusher.secret'),
            \Config::get('broadcasting.connections.pusher.app_id'),
            array('cluster' => 'eu', 'encrypted' => true)
        );
    }

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
            $result = $user->categories()->syncWithoutDetaching($category);

            if($result['attached'])
            {
                $this->pusher->trigger('whiteboard', 'signup', array(
                    'category' => $category->id,
                    'user' => array(
                        'id' => $user->id,
                        'name' => $user->name
                    )
                ));
            }
        }
        return redirect()->route('home');
    }

    public function signOff(User $user, Category $category)
    {
        if (Gate::allows('edit-own', $user) && $category->published)
        {
            $result = $user->categories()->detach($category);
            if($result)
            {
                $this->pusher->trigger('whiteboard', 'signoff', array(
                    'category' => $category->id,
                    'user' => array(
                        'id' => $user->id,
                    )
                ));
            }
        }
        return redirect()->route('home');
    }
}
