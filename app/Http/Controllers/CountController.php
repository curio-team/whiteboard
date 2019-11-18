<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \StudioKaa\Amoclient\Facades\AmoAPI;

use App\User;

class CountController extends Controller
{
	public function index()
	{
		$groups = AmoAPI::get('/groups');
		$users = User::orderBy('pushes', 'DESC')->get();

		$groups = $groups->map(function($item, $key){
			$item['selected'] = false;
			return $item;
		});

		return view('admin.count.index')
			->with(compact('users'))
			->with(compact('groups'));
	}

	public function filter(Request $request)
	{
		if(!$request->groups) return $this->index();

		$ids = array();
		foreach($request->groups as $group)
		{
			$group = AmoAPI::get('/groups/' . $group);
			$students = collect($group['users']);
			$students = $students->map(function($item, $key){
				$item['id'] = "'" . $item['id'] . "'";
				return $item;
			});
			$ids[] = $students->implode('id', ',');
		}

		$ids = implode(',', $ids);

		$groups = collect(AmoAPI::get('/groups'));
		$groups = $groups->map(function($item, $key) use($request){
			$item['selected'] = in_array($item['id'], $request->groups) ? true : false;
			return $item;
		});

		$users = User::whereRaw('id IN (' . $ids . ')')->orderBy('pushes', 'DESC')->get();
		return view('admin.count.index')
			->with(compact('users'))
			->with(compact('groups'));
	}
}
