<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use App\Models\User;

class ClientController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::whereHas('roles', function($q){$q->whereIn('roles.name', ['client']);})->get();        
        $role = Role::where('name', 'client')->first();
        
        return view('admin.clients.index', compact('users','role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|not_in:all',
            'password' => 'required|min:6|confirmed',   
            'mobile' => 'required',
            'designation' => 'required',
            'address' => 'required'    
        ]);        

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $client = new User();

        $client->name = $request->name;
        $client->email = $request->email;
        $client->password = bcrypt($request->password);

        $client->save();
        
        $client->assignRole($request->role);

        $client->clientDetails()->create([
            'mobile' => $request->mobile,
            'designation' => $request->designation,
            'address' => $request->address
        ]);
        
        return response()->json(['msg'=>'Client created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::with('clientDetails')->where('id',$request->get('id'))->first();   

        $clientRole = $user->getRoleNames()[0];
        
        $role = Role::where('name','client')->first();         

        $contents = View::make('admin.clients.partials._edit', ['user' => $user, 'role' => $role, 'clientRole' => $clientRole]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 ); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->id.',id',
            'role' => 'required|not_in:all',            
            'mobile' => 'required',
            'designation' => 'required',
            'address' => 'required'    
        ]);        

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }
        
        $client = User::find($request->get('id'));
        
        $client->name = $request->name;
        $client->email = $request->email;
        
        $client->save();

        $client->syncRoles([$request->role]);

        $client->clientDetails()->update([
            'mobile' => $request->mobile,
            'designation' => $request->designation,
            'address' => $request->address
        ]);

        return response()->json(['msg'=>'Client updated successfully'], 200);        

    }

    public function destroy(Request $request)
    {
        $client = User::where('name', $request->get('client'))->first();
        
        if ($client->delete()) {
            return response()->json(['msg'=> 'Client deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting client'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (User::destroy($request->get('clients'))) {
            return response()->json(['msg'=> 'Selected clients deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected clients'], 400);
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
        $totalRecords = User::select('count(*) as allcount')->whereHas('roles', function($q){$q->whereNotIn('roles.name', ['admin','employee']);})->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->whereHas('roles', function($q){$q->whereNotIn('roles.name', ['admin','employee']);})->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = User::orderBy($columnName,$columnSortOrder)
        ->where('users.name', 'like', '%' .$searchValue . '%')
        ->whereHas('roles', function($q){$q->whereNotIn('roles.name', ['admin','employee']);})
        ->select('users.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            if (!$record->getRoleNames()->contains('admin', 'employee')) {
                $id = $record->id;
                $name = $record->name;
                $email = $record->email;
                $roles = $record->getRoleNames();
                $created_at = $record->created_at->diffForHumans();
                $updated_at = $record->updated_at->diffForHumans();

                $data_arr[] = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "roles" => $roles,
                    "created_at" => $created_at,
                    "updated_at" => $updated_at
                  );
            }                        
    
            
         }
    
         $response = array(
            //"draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $data_arr
         );
    
         echo json_encode($response);
         exit;

        


        // $users = User::all();
        
        // print_r($request->get('draw'));
        // exit;
        //return response()->json($users);
    }

}
