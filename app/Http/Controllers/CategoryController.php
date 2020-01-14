<?php 
 
namespace App\Http\Controllers; 
 
use App\Group;
use Illuminate\Http\Request;
use App\Category; 
use App\User; 
use Auth; 
use Gate; 
use \StudioKaa\Amoclient\Facades\AmoAPI;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller 
{ 
    /** 
     * Display a listing of the resource. 
     * 
     * @return \Illuminate\Http\Response 
     */ 

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
        $categories = Category::all(); 
        return view('admin.categories.index', compact('categories')); 
    } 
 
    public function toggle(Category $category) 
    { 
        $category->published = $category->published ? false : true; 
        $category->save(); 
        return back(); 
    } 
 
    public function clear(Category $category)
    {
        $category->users()->detach();
        return back();
    }

    /** 
     * Show the form for creating a new resource. 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function create() 
    { 
        $groups = AmoAPI::get('/groups');
        foreach($groups as $groupKey => $group){
            if($group['type'] != 'class')
            {
                unset($groups[$groupKey]);
            }
        }
        
        return view('admin.categories.create')->with('groups',$groups); 
    } 
 
    /** 
     * Store a newly created resource in storage. 
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response 
     */ 
    public function store(Request $request) 
    {
//        dd($request->all());

        $request->validate([ 
            'name' => 'string|required', 
            'published' => 'required|min:0|max:1', 
        ]);

        $groups = AmoAPI::get('/groups');
        $selected_groups = array();

        foreach($groups as $groupKey => $group){
            if($request->has($group['id'])){
                array_push($selected_groups, $group['id']);
            }
        }

        $category = new Category(); 
        $category->name = $request->name; 
        $category->published = $request->published; 
        $category->save(); 
 
        foreach($selected_groups as $group_id)
        {
            $group = new Group();
            $group->id = $group_id;
            
            $result = $group->Categories()->syncWithoutDetaching($category);

        }

        return redirect()->route('categories.index'); 
    } 
 
    /** 
     * Show the form for editing the specified resource. 
     * 
     * @param  int  $id 
     * @return \Illuminate\Http\Response 
     */ 
    public function edit(Category $category)
    {

        $groups = AmoAPI::get('/groups');

        foreach($groups as $groupKey => $group){
            if($group['type'] != 'class')
            {
                unset($groups[$groupKey]);
            }
        }

        $db_groups = DB::table('groups_categories_pivot')->where('category_id', '=', $category->id)->get();
        $selected_groups = array();

        $count = -1;
        foreach ($groups as $group){
            $count++;
            $selected_group = [ 'id' => $group['id'],'name' => $group['name'], 'selected' => 0 ];

            foreach ($db_groups as $db_group){
                if($selected_group['id'] == $db_group->group_id){
                    $selected_group['selected'] = 1;
                    break;
                }
            }
            array_push($selected_groups, $selected_group);
        }
        
        // dit is the value met alle gegevens $selected_groups

        return view('admin.categories.edit')
            ->with('category', $category)
            ->with('groups', $groups)
            ->with('selected_groups', $selected_groups);
    } 
 
    /** 
     * Update the specified resource in storage. 
     * 
     * @param  \Illuminate\Http\Request  $request 
     * @param  int  $id 
     * @return \Illuminate\Http\Response 
     */ 
    public function update(Request $request, Category $category) 
    { 
        $request->validate([ 
            'name' => 'string|required', 
            'published' => 'required|min:0|max:1', 
        ]); 
 
        $category->name = $request->name; 
        $category->published = $request->published; 
        $category->save(); 
 
        

        $groups = AmoAPI::get('/groups');
        $selected_groups = array();

        foreach($groups as $groupKey => $group){
            if($request->has($group['id'])){
                array_push($selected_groups, $group['id']);
            }
        }

        //delete all pivot's
        foreach($groups as $group_id)
        {
            $group = new Group();
            $group->id = $group_id['id'];

            $result = $group->Categories()->detach($category);
        }

//        dd($request->all());

        //and pivot them again
         foreach($selected_groups as $group_id)
         {

             $group = new Group();
             $group->id = $group_id;
            
             $result = $group->Categories()->syncWithoutDetaching($category);

         }
        return redirect()->route('categories.index'); 
    } 
 
    public function delete(Category $category) 
    { 
        return view('admin.categories.delete')->with('category', $category); 
    } 
 
    /** 
     * Remove the specified resource from storage. 
     * 
     * @param  int  $id 
     * @return \Illuminate\Http\Response 
     */ 
    public function destroy(Category $category) 
    { 
        $category->users()->detach(); 
        $category->delete(); 
        return redirect()->route('categories.index'); 
    } 
} 
