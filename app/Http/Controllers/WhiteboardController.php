<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Category;
use App\User;
use App\Announcement;
use Auth;
use Gate;
use StudioKaa\Amoclient\Facades\AmoAPI;
use Illuminate\Support\Facades\DB;

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
        $me = AmoAPI::get('/me');

        if($me['type'] == 'student'){
            $groups = DB::table('groups_categories_pivot')->where('group_id', '=', $me['groups'][0]['id'])->get();
            $cat_ids = array();

            foreach ($groups as $group){
                array_push($cat_ids, $group->category_id);
            }

            $categories = Category::whereIn('id', $cat_ids)->where('published', true)->with(['users' => function ($q) {
                $q->orderBy('users_categories_pivot.created_at', 'asc');
            }])->get();
        }

        else{
            $categories = Category::where('published', true)->with(['users' => function ($q) {
                $q->orderBy('users_categories_pivot.created_at', 'asc');
            }])->get();
        }

        $announcements = Announcement::orderBy('created_at', 'desc')->get();

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
                        'name' => $user->name,
                        'time' => date('d/m H:i')
                    )
                ));
                
                $user->pushes++;
                $user->save();
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
