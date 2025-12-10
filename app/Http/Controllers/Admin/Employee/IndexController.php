<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Controllers\Common\ImageUpload;
use Carbon\Carbon;

class IndexController extends Controller
{

    use ImageUpload;

    //index
    public function index(){
        $paginate       = Request('paginate', 10);
        $search         = Request('search', '');
        $sort_direction = Request('sort_direction', 'desc');
        $sort_field     = Request('sort_field', 'id');
        $sex            = Request('sex', '');
        $search_field   = Request('search_field', '');

        // $allData = Employee::orderBy($sort_field, $sort_direction)
        //         ->search( trim(preg_replace('/\s+/', ' ', $search)) )
        //         ->paginate($paginate);

        $filterData = Employee::orderBy($sort_field, $sort_direction);

        if(!empty($sex)){
            $filterData->where('gender', $sex);
        }

        if(!empty($search_field)){
            $search_value = trim(preg_replace('/\s+/' ,' ', $search));
            $filterData->where($search_field, 'LIKE', '%'.$search_value.'%');
        }else{
            $filterData->search( trim(preg_replace('/\s+/' ,' ', $search)) );
        }

        $allData =  $filterData->paginate($paginate);

        return response()->json($allData, 200);

    }

    // store
    public function store(Request $request){

        //Validate
        $this->validate($request,[
            'employee_name'   => 'required|string|max:100',
            'email'           => 'required|email',
            'mobile'          => 'required|numeric',
            'gender'          => 'required',
            'e_type'          => 'required',
            'e_skills'        => 'required',
            'sports'          => 'required',
        ]);

        $data = new Employee();

        $imagePath      = 'images/employee/';
        // Save Image 
        $current_image  = $request->image; 
        if(!empty($current_image)){
            $imgName= $this->imageUplaodByName($current_image, null, $imagePath); 
            $data->image = $imgName;
        }

        $data->employee_name = $request->employee_name;
        $data->email         = $request->email;
        $data->mobile        = $request->mobile;
        $data->gender        = $request->gender;
        $data->e_type        = $request->e_type;
        $data->others        = $request->others;
        $data->time          = $request->time;
        $data->my_date       = date('d-m-Y', strtotime($request->my_date));
        $data->e_skills      = implode(',', $request->e_skills);
        $data->sports        = implode(',', $request->sports);
        $success             = $data->save();

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
            'employee_name'      => 'required|string|max:100',
            'email'           => 'required|email',
            'mobile'       => 'required|numeric',
            'gender'          => 'required',
            'e_type'          => 'required',
            'e_skills'        => 'required',
            'sports'          => 'required',
        ]);
        
        $data                = Employee::find($request->id);

        $imagePath      = 'images/employee/';
        // Save Image 
        $current_image  = $request->image; 
        $old_image      = $data->image;
        if($current_image != $old_image){
            $imgName= $this->imageUplaodByName($current_image, $old_image, $imagePath); 
            $data->image = $imgName;
        }

        $data->employee_name  = $request->employee_name;
        $data->email          = $request->email;
        $data->mobile         = $request->mobile;
        $data->gender         = $request->gender;
        $data->e_type         = $request->e_type;
        $data->others         = $request->others;
        $data->time           = $request->time;
        $data->my_date        = date('d-m-Y', strtotime($request->my_date));
        $data->e_skills       = implode(',', $request->e_skills);
        $data->sports         = implode(',', $request->sports);
        $success              = $data->save();

        if($success){
            return response()->json(['msg'=>'Updated Successfully &#128515;', 'icon'=>'success'], 200);
        }else{
            return response()->json(['msg' => 'Data not save in DB !!'], 422);
        }

    }


    // destroy
    public function destroy($id)
    {
        $data       =  Employee::find($id);

        $imagePath      = 'images/employee/';
        $imagePathSm    = $imagePath . 'small/';
      
        $old_image      = $data->image;
        if(!empty($old_image)){
            //Delete Old File
            if (file_exists($imagePath . $old_image)){
                unlink( $imagePath . $old_image );
            }
            if (file_exists($imagePathSm . $old_image)){
                unlink( $imagePathSm . $old_image );
            }
        }

        $success    =  $data->delete();
        return response()->json('success', 200);

    }

    //Bulk delete
    public function deleteAll(Request $request){
        $count = 0;
        foreach($request->data as $id){
            $category       =  Employee::find($id);
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
            $category         =  Employee::find($id);
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
            $category         =  Employee::find($id);
            $category->status = 0;
            $category->save();
            $count++;
        }
        $success = $count > 0 ? true : false;
        return response()->json(['success' => $success, 'total' => $count], 200);

    }

    // status
    public function status($id){

        $data       =  Employee::find($id);
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

}
