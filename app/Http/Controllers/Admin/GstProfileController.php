<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GstProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class GstProfileController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $gstProfiles = GstProfile::all();
        return view('admin.gst-profiles.index', compact('gstProfiles'));
    }

    public function show(Request $request)
    {
        $gstProfile = GstProfile::where('id',$request->get('id'))->first();            

        $contents = View::make('admin.gst-profiles.partials._edit', ['gstProfile' => $gstProfile]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 );        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'company_gst_number' => 'required|unique:gst_profiles,company_gst_number',
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }
        
        if (GstProfile::create(['company_name' => $request->company_name, 'company_gst_number' => $request->company_gst_number]))
        {
            return response()->json(['msg'=> 'GST profile added successfully!'], 200);    
        }

        return response()->json(['msg'=> 'Error in adding gst profile'], 200);

    }

    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gst' => 'required|unique:gst_profiles,company_gst_number,'.$request->id.',id',        
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $gstProfile = GstProfile::find($request->id);
        $gstProfile->company_name = $request->name;
        $gstProfile->company_gst_number = $request->gst;

        if($gstProfile->save()) 
        {
            return response()->json(['msg'=> 'GST profile updated successfully! '], 200);    
        } 

        return response()->json(['msg'=> 'Error in updating gst profile'], 200);
    }

    public function destroy(Request $request)
    {
        $gstProfile = GstProfile::where('company_name', $request->get('gstProfile'))->first();
        
        if ($gstProfile->delete()) {
            return response()->json(['msg'=> 'GST profile deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting gst profile'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (GstProfile::destroy($request->get('gstProfiles'))) {
            return response()->json(['msg'=> 'Selected gst profiles deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected gst profiles'], 400);
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
        $totalRecords = GstProfile::select('count(*) as allcount')->count();
        $totalRecordswithFilter = GstProfile::select('count(*) as allcount')->where('company_name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = GstProfile::orderBy($columnName,$columnSortOrder)
        ->where('gst_profiles.company_name', 'like', '%' .$searchValue . '%')        
        ->select('gst_profiles.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $company_name = $record->company_name;  
            $company_gst_number = $record->company_gst_number;
            $created_at = $record->created_at->diffForHumans();
            $updated_at = $record->updated_at->diffForHumans();
    
            $data_arr[] = array(
              "id" => $id,
              "company_name" => $company_name,                  
              "company_gst_number" => $company_gst_number,
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
