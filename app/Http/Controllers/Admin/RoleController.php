<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        
        return view('admin.roles.index', compact('roles', 'permissions'));
    }    

    public function show(Request $request)
    {
        $role = Role::with('permissions')->where('id',$request->get('id'))->first();            

        $contents = View::make('admin.roles.partials._edit', ['role' => $role]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 );        
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',        
        ]);

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $role = new Role;
        $role->name = $request->get('name');
        $role->save();
        //Role::create(['name' => $request->name]);        

        if ( $request->get('permissions') ) {
            $role->syncPermissions($request->get('permissions'));            
        } else {
            $role->syncPermissions([]);
        }

        return response()->json(['msg'=> 'Role created and permission assiged successfully!'], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,id,'.$request->id.',id',       
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->save();        

        if ( count($request->get('permissions')) > 0 ) {            
            $role->syncPermissions($request->get('permissions'));            
        }

        return response()->json(['msg'=> 'Role updated and permission assiged successfully! '], 200);
    }

    public function destroy(Request $request)
    {
        $role = Role::where('name', $request->get('role'))->first();
        
        if ($role->delete()) {
            return response()->json(['msg'=> 'Role deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting role'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (Role::destroy($request->get('roles'))) {
            return response()->json(['msg'=> 'Selected roles deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected roles'], 400);
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
        $totalRecords = Role::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Role::orderBy($columnName,$columnSortOrder)
        ->where('roles.name', 'like', '%' .$searchValue . '%')        
        ->select('roles.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;            
            $slug = $record->name;
            $created_at = $record->created_at->diffForHumans();
            $updated_at = $record->updated_at->diffForHumans();
    
            $data_arr[] = array(
              "id" => $id,
              "name" => $name,    
              "slug" => $slug,          
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
