<?php 
 
namespace App\Http\Controllers; 
 
use Illuminate\Http\Request; 
use App\Category; 
use App\User; 
use App\Scripts;
use Auth; 
use Gate; 
 
class TimerController extends Controller 
{ 
    public function update()
    {
        $categories = Category::all();
        $arrayToString = NULL;
        $rowEnd = ";";
        $columnEnd = "+";
        $catEnd = "@";
        

        foreach ($categories as $categorie)
        {
            if ($arrayToString != NULL){ $arrayToString = $arrayToString . $catEnd; }
            foreach($categorie->users as $user)
            {
                $temp = $arrayToString;
                $arrayToString = ((((isset($arrayToString)) || (!is_null($arrayToString))) && (substr($temp, -1) != $catEnd))  ? $arrayToString . $rowEnd : $arrayToString)
                                . $user->pivot->updated_at->toTimeString() . $columnEnd 
                                . $user->name . $columnEnd 
                                . $user->id . $columnEnd
                                . ((!isset($user->pivot->description) || is_null($user->pivot->description)) ? "null" : $user->pivot->description) . $columnEnd 
                                . ((Gate::allows('edit-own', $user)) ? "true" : "null" );
            }
        }

        echo $arrayToString;
    }
} 