<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IndexController extends Controller
{
    //index
    public function index(){
        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');

        $allData = User::orderBy($sort_field, $sort_direction)
                ->search( trim(preg_replace('/\s+/', ' ', $search)) )
                ->paginate($paginate);

        return response()->json($allData, 200);

    }

    // store
    public function store(Request $request){

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required',
            'password' => 'min:6|required_with:password_confirm|same:password_confirm'
        ]);

        $data = new User();
        $data->name          = $request->name;
        $data->email         = $request->email;
        $data->phone         = $request->phone;
        $data->password      = Hash::make($request->password);
        $success             = $data->save();

        // Role Sync 
        //$data->roles()->sync($request->role_id);

        if($success){
            return response()->json(['msg'=>'Save Successfully &#128513;', 'icon'=>'success'], 200);
        }else{
            return response()->json(['msg' => 'Data not save in DB !!'], 422);
        }

    }


    // update
    public function update(Request $request){

        //Validate
        $this->validate($request,[
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,'.$request->id,
            'phone'    => 'required',
        ]);
        
        $data                = User::find($request->id);
        $data->name          = $request->name;
        $data->email         = $request->email;
        $data->phone         = $request->phone;

        // Role Sync
        //$data->roles()->sync($request->role_id);

        $success             = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json(['msg' => 'Data not save in DB !!'], 422);
        }

    }

    //with form fill
    // public function updateRole(Request $request){
    
    //     $data                = User::find($request->id);
    //     // Role Sync
    //     $data->roles()->sync($request->role_id);
    //     $success             = $data->save();

    //     if($success){
    //         return response()->json(['msg'=>'Role Updated Successfully &#128515;', 'icon'=>'success'], 200);
    //     }else{
    //         return response()->json([
    //             'msg' => 'Data not save in DB !!'
    //         ], 422);
    //     }

    // }

    //with axios
    public function updateRole(Request $request){
        $request = (object) $request['data'];
        //dd($request->id);
        //dd($request['data']['id'], $request->all());

        $data                = User::find($request->id);
        // Role Sync
        $data->roles()->sync($request->role_id);
        $success             = $data->save();

        if($success){
            return response()->json(['msg'=>'Role Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json(['msg' => 'Data not save in DB !!'], 422);
        }
    
    }


    // destroy
    public function destroy($id)
    {
        $data       =  User::find($id);
        $success    =  $data->delete();
        return response()->json('success', 200);

    }

    // destroyTemp
    public function delete_temp($id){


        $data                   = User::findOrFail($id);
        $data->deleted_temp     = 1;
        $data->delete_by        = Auth::user()->id;
        $data->updated_at       = Carbon::now();
        $success                = $data->save();

        if($success){
            return response()->json(['msg'=>'Deleted Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json([
                'msg' => 'Data is not deleted !!'
            ], 422);
        }
    }

    //Bulk delete
    public function deleteAll(Request $request){
        $count = 0;
        foreach($request->data as $id){
            $category       =  User::find($id);
            $category->delete();
            $count++;
        }
        $success = $count > 0 ? true : false;
        return response()->json(['success' => $success, 'total' => $count], 200);

    }

    //Bulk status active
    public function statusActiveAll(Request $request){
        $count = 0;
        foreach($request->data as $id){
            $category         =  User::find($id);
            $category->status = 1;
            $category->save();
            $count++;
        }
        $success = $count > 0 ? true : false;
        return response()->json(['success' => $success, 'total' => $count], 200);
    }

    //Bulk status deactive
    public function statusDeactiveAll(Request $request){
        $count = 0;
        foreach($request->data as $id){
            $category         =  User::find($id);
            $category->status = 0;
            $category->save();
            $count++;
        }
        $success = $count > 0 ? true : false;
        return response()->json(['success' => $success, 'total' => $count], 200);

    }

    // status
    public function status($id){

        $data       =  User::find($id);
        if($data){
           $status = $data->status;
            if($status == 1){
                $data->status = 0;
            }else{
                $data->status = 1;
            }
            $success    =  $data->save();
            return response()->json('success', 200);

        }

    }

    //ajax get roles
    public function getRoles(){
        $roles = Role::all();
        return response()->json(['get_all_roles'=>$roles],200);
    }

    
}