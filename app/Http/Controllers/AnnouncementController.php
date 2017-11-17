<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use Auth;
use Session;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::all();
        return view('admin.announcements.index')->with('announcements', $announcements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Session::flash('back_url', $request->server('HTTP_REFERER'));
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ 
            'title' => 'string|required', 
            'body' => 'string|nullable', 
        ]);

        $announcement = new Announcement();
        $announcement->author_id = Auth::user()->id;
        $announcement->title = $request->title;
        $announcement->body = nl2br($request->body);
        $announcement->save();

        return ($url = Session::get('back_url'))
            ? redirect()->to($url)
            : redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit')->with('announcement', $announcement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([ 
            'title' => 'string|required', 
            'body' => 'string|nullable', 
        ]);

        $announcement->title = $request->title;
        $announcement->body = $request->body;
        $announcement->save();

        return redirect()->route('announcements.index');
    }

    public function delete(Request $request, Announcement $announcement)
    {
        Session::flash('back_url', $request->server('HTTP_REFERER'));
        return view('admin.announcements.delete')->with('announcement', $announcement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $url = Session::get('back_url');
        $edit = route('announcements.edit', $announcement->id);
        $announcement->delete();

        return ($url == $edit)
            ? redirect()->route('announcements.index')
            : redirect()->to($url);
    }
}
