<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class TypeController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }

    public function show(Request $request)
    {
        $type = Type::where('id',$request->get('id'))->first();            

        $contents = View::make('admin.types.partials._edit', ['type' => $type]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 );        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:types,name',        
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }
        
        if (Type::create(['name' => $request->name]))
        {
            return response()->json(['msg'=> 'Client type added successfully!'], 200);    
        }

        return response()->json(['msg'=> 'Error in adding client type'], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:types,id,'.$request->id.',id',       
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $type = Type::find($request->id);
        $type->name = $request->name;

        if($type->save()) 
        {
            return response()->json(['msg'=> 'Client Type updated successfully! '], 200);    
        } 

        return response()->json(['msg'=> 'Error in updating client type'], 200);
    }

    public function destroy(Request $request)
    {
        $type = Type::where('name', $request->get('type'))->first();
        
        if ($type->delete()) {
            return response()->json(['msg'=> 'Client type deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting client type'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (Type::destroy($request->get('types'))) {
            return response()->json(['msg'=> 'Selected client types deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected client types'], 400);
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
        $totalRecords = Type::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Type::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Type::orderBy($columnName,$columnSortOrder)
        ->where('types.name', 'like', '%' .$searchValue . '%')        
        ->select('types.*')
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
