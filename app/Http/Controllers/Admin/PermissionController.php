<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('admin.permissions.index', compact('permissions','roles'));
    }

    public function show(Request $request)
    {

        $permission = Permission::find($request->get('id'));

        return response()->json(['data'=> $permission], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',        
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        Permission::create(['name' => $request->name]);

        return response()->json(['msg'=> 'Permission created successfully!'], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,id,'.$request->id.',id',       
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $permission = Permission::find($request->id);
        $permission->name = $request->name;
        $permission->save();        

        return response()->json(['msg'=> 'Permission updated successfully!'], 200);
    }

    public function destroy(Request $request)
    {
        $permission = Permission::where('name', $request->get('permission'))->first();
        
        if ($permission->delete()) {
            return response()->json(['msg'=> 'Permission deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting permission'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (Permission::destroy($request->get('permissions'))) {
            return response()->json(['msg'=> 'Selected permissions deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected permissions'], 400);
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

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[1]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

         // Total records
        $totalRecords = Permission::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Permission::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Permission::orderBy($columnName,$columnSortOrder)
        ->where('permissions.name', 'like', '%' .$searchValue . '%')
        ->select('permissions.*')
        ->skip($start)
        ->take($rowperpage)        
        ->get();

        $data_arr = array();

        foreach($records as $record){                        

            $data = explode('-',$record->name);            

            $id = $record->id;
            $name = isset($data[0]) ? ucwords( str_replace('_', ' ', $data[0] ) ) : '';            
            $slug =  $record->name; //isset($data[1]) ? $data[1] : '';
            $permission = isset($data[1]) ? $data[1] : '';            
            $created_at = $record->created_at->diffForHumans();
            $updated_at = $record->updated_at->diffForHumans();            

            $data_arr[] = array(
              "id" => $id,
              "name" => $name,    
              "slug" => $slug,    
              "permission" => $permission,              
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
