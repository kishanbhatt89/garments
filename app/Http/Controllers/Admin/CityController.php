<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CityController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $cities = City::all();
        return view('admin.cities.index', compact('cities'));
    }

    public function show(Request $request)
    {
        $city = City::where('id',$request->get('id'))->first();            

        $contents = View::make('admin.cities.partials._edit', ['city' => $city]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 );        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cities,name',        
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }
        
        if (City::create(['name' => $request->name]))
        {
            return response()->json(['msg'=> 'City added successfully!'], 200);    
        }

        return response()->json(['msg'=> 'Error in adding city'], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cities,id,'.$request->id.',id',       
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $city = City::find($request->id);
        $city->name = $request->name;

        if($city->save()) 
        {
            return response()->json(['msg'=> 'City updated successfully! '], 200);    
        } 

        return response()->json(['msg'=> 'Error in updating city'], 200);
    }

    public function destroy(Request $request)
    {
        $city = City::where('name', $request->get('city'))->first();
        
        if ($city->delete()) {
            return response()->json(['msg'=> 'City deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting city'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (City::destroy($request->get('cities'))) {
            return response()->json(['msg'=> 'Selected cities deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected cities'], 400);
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
        $totalRecords = City::select('count(*) as allcount')->count();
        $totalRecordswithFilter = City::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = City::orderBy($columnName,$columnSortOrder)
        ->where('cities.name', 'like', '%' .$searchValue . '%')        
        ->select('cities.*')
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
