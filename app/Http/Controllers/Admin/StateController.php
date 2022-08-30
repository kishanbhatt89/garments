<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class StateController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $states = State::all();
        return view('admin.states.index', compact('states'));
    }

    public function show(Request $request)
    {
        $state = State::where('id',$request->get('id'))->first();            

        $contents = View::make('admin.states.partials._edit', ['state' => $state]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 );        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:states,name',        
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }
        
        if (State::create(['name' => $request->name]))
        {
            return response()->json(['msg'=> 'State added successfully!'], 200);    
        }

        return response()->json(['msg'=> 'Error in adding state'], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:states,id,'.$request->id.',id',       
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $state = State::find($request->id);
        $state->name = $request->name;

        if($state->save()) 
        {
            return response()->json(['msg'=> 'State updated successfully! '], 200);    
        } 

        return response()->json(['msg'=> 'Error in updating state'], 200);
    }

    public function destroy(Request $request)
    {

        $state = State::where('name', $request->get('state'))->first();
        
        $store = Store::where('state_id',$state->id)->first();

        if ($store) {
            return response()->json(['msg'=> 'Error in deleting state. Because state exist in store record.'], 400);    
        }

        if ($state->delete()) {
            return response()->json(['msg'=> 'State deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting state'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (State::destroy($request->get('states'))) {
            return response()->json(['msg'=> 'Selected states deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected states'], 400);
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
        $totalRecords = State::select('count(*) as allcount')->count();
        $totalRecordswithFilter = State::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = State::orderBy($columnName,$columnSortOrder)
        ->where('states.name', 'like', '%' .$searchValue . '%')        
        ->select('states.*')
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
