<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;
use Auth;

class IndexController extends Controller
{
    //index
    public function index(){

        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        //$allData = Role::get()->toArray();
        $allData = Role::with('usedRole:id,role_id')
                ->orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/' ,' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // store
    public function store(Request $request){

        //Validate
        $this->validate($request,[
            'name'       => 'required|string|max:100',
        ]);

        $data = new Role();

        $data->name          = $request->name;
        $data->created_by    = Auth::user()->id;
        $success             = $data->save();

        if($success){
            return response()->json(['msg'=>'Stored Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    // update
    public function update(Request $request){

        //Validate
        $this->validate($request,[
            'name'       => 'required|string|max:100',
        ]);
        
        $data         = Role::find($request->id);
        $data->name   = $request->name;
        $success      = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data not save in DB !!'
            ], 422);
        }

    }

    // destroy
    public function destroy($id)
    {
        $data       =  Role::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);

    }

    //Bulk delete
    public function deleteAll(Request $request){
        $count = 0;
        foreach($request->data as $id){
            $role       =  Role::find($id);
            $role->delete();
            $count++;
        }
        $success = $count > 0 ? true : false;
        return response()->json(['success' => $success, 'total' => $count], 200);
    }

}
