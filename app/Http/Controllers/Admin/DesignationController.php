<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class DesignationController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $designations = Designation::all();
        return view('admin.designations.index', compact('designations'));
    }

    public function show(Request $request)
    {
        $designation = Designation::where('id',$request->get('id'))->first();            

        $contents = View::make('admin.designations.partials._edit', ['designation' => $designation]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 );        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:designations,name',        
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }
        
        if (Designation::create(['name' => $request->name]))
        {
            return response()->json(['msg'=> 'Designation added successfully!'], 200);    
        }

        return response()->json(['msg'=> 'Error in adding designation'], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:designations,id,'.$request->id.',id',       
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $designation = Designation::find($request->id);
        $designation->name = $request->name;

        if($designation->save()) 
        {
            return response()->json(['msg'=> 'Designation updated successfully! '], 200);    
        } 

        return response()->json(['msg'=> 'Error in updating designation'], 200);
    }

    public function destroy(Request $request)
    {
        $designation = Designation::where('name', $request->get('designation'))->first();
        
        if ($designation->delete()) {
            return response()->json(['msg'=> 'Designation deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting designation'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (Designation::destroy($request->get('designations'))) {
            return response()->json(['msg'=> 'Selected designations deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected designations'], 400);
    }    

    public function table(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');        
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        // print_r($columnIndex_arr);
        // exit;

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[1]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

         // Total records
        $totalRecords = Designation::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Designation::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Designation::orderBy($columnName,$columnSortOrder)
        ->where('designations.name', 'like', '%' .$searchValue . '%')        
        ->select('designations.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;                        
            $created_at = $record->created_at->diffForHumans();
            $updated_at = $record->updated_at->diffForHumans();
    
            $data_arr[] = array(
              "id" => $id,
              "name" => $name,                  
              "created_at" => $created_at,
              "updated_at" => $updated_at
            );
         }
    
         $response = array(
            //"draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data_arr
         );
    
         echo json_encode($response);
         exit;
    }
}
