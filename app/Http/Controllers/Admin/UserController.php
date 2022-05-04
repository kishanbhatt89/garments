<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
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
        $users=User::whereHas('roles', function($q){$q->whereIn('roles.name', ['employee']);})->get();        
        $role = Role::where('name', 'employee')->first();
        
        return view('admin.employees.index', compact('users','role'));
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

        $employee = new User();

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->password = bcrypt($request->password);

        $employee->save();
        
        $employee->assignRole($request->role);

        $employee->userDetails()->create([
            'mobile' => $request->mobile,
            'designation' => $request->designation,
            'address' => $request->address
        ]);

        return response()->json(['data'=>'Employee created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::with('userDetails')->where('id',$request->get('id'))->first();   

        $userRole = $user->getRoleNames()[0];
        
        $roles = Role::all();         

        $contents = View::make('admin.employees.partials._edit', ['user' => $user, 'roles' => $roles, 'userRole' => $userRole]);
        
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
        
        $employee = User::find($request->get('id'));
        
        $employee->name = $request->name;
        $employee->email = $request->email;
        
        $employee->save();

        $employee->syncRoles([$request->role]);

        $employee->userDetails()->update([
            'mobile' => $request->mobile,
            'designation' => $request->designation,
            'address' => $request->address
        ]);

        return response()->json(['msg'=>'Employee updated successfully'], 200);        

    }

    public function destroy(Request $request)
    {
        $employee = User::where('name', $request->get('employee'))->first();
        
        if ($employee->delete()) {
            return response()->json(['msg'=> 'Employee deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting employee'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (User::destroy($request->get('employees'))) {
            return response()->json(['msg'=> 'Selected employees deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected employees'], 400);
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
        $totalRecords = User::select('count(*) as allcount')->whereHas('roles', function($q){$q->whereNotIn('roles.name', ['admin']);})->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->whereHas('roles', function($q){$q->whereNotIn('roles.name', ['admin']);})->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = User::orderBy($columnName,$columnSortOrder)
        ->where('users.name', 'like', '%' .$searchValue . '%')
        ->whereHas('roles', function($q){$q->whereNotIn('roles.name', ['admin']);})
        ->select('users.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            if (!$record->getRoleNames()->contains('admin')) {
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

    public function showSettings()
    {
        $settings = auth()->user()->settings;        
        return view('admin.settings.index', compact('settings'));
    }

    public function saveSettings(Request $request)
    {                        
        if (
            $request->has('company_name') && $request->has('company_address')
        ) {            

            $user = User::find(auth()->user()->id);

            if (isset($user->settings)) {         
                
                $user->update([
                    'settings->general->company_name' => $request->company_name,
                    'settings->general->company_address' => $request->company_address
                ]);                       

            } else {             

                $user->update([
                    'settings' => [
                        'general' => [
                            'company_name' => $request->company_name,
                            'company_address' => $request->company_address                    
                        ],                        
                    ]
                ]);

            }                        
                        
            return response()->json(['msg'=> 'General settings updated successfully!'], 200);
        }    


        if (
            $request->has('company_mail_mailer') || 
            $request->has('company_mail_host') ||
            $request->has('company_mail_port') ||
            $request->has('company_mail_username') ||
            $request->has('company_mail_password') ||
            $request->has('company_mail_encryption') ||
            $request->has('company_mail_from_address') ||
            $request->has('company_mail_from_name')
        ) {            
            
            $user = User::find(auth()->user()->id);
            
            if (isset($user->settings)) {         
                
                $user->update([
                    'settings->email->company_mail_mailer' => $request->company_mail_mailer,
                    'settings->email->company_mail_host' => $request->company_mail_host,
                    'settings->email->company_mail_port' => $request->company_mail_port,
                    'settings->email->company_mail_username' => $request->company_mail_username,
                    'settings->email->company_mail_password' => $request->company_mail_password,
                    'settings->email->company_mail_encryption' => $request->company_mail_encryption,
                    'settings->email->company_mail_from_address' => $request->company_mail_from_address,
                    'settings->email->company_mail_from_name' => $request->company_mail_from_name                
                ]);                       

            } else {             

                $user->update([
                    'settings' => [
                        'email' => [
                            'company_mail_mailer' => $request->company_mail_mailer,
                            'company_mail_host' => $request->company_mail_host,
                            'company_mail_port' => $request->company_mail_port,
                            'company_mail_username' => $request->company_mail_username,
                            'company_mail_password' => $request->company_mail_password,
                            'company_mail_encryption' => $request->company_mail_encryption,
                            'company_mail_from_address' => $request->company_mail_from_address,
                            'company_mail_from_name' => $request->company_mail_from_name                        
                        ],                        
                    ]
                ]);
                
            }                        
                        
            return response()->json(['msg'=> 'Email settings updated successfully!'], 200);
        }

        
        if (
            $request->has('company_mobile') && $request->has('company_email')
        ) {            

            $user = User::find(auth()->user()->id);

            if (isset($user->settings)) {         
                
                $user->update([
                    'settings->support->company_mobile' => $request->company_mobile,
                    'settings->support->company_email' => $request->company_email
                ]);                       

            } else {             

                $user->update([
                    'settings' => [
                        'support' => [
                            'company_mobile' => $request->company_mobile,
                            'company_email' => $request->company_email                    
                        ],                        
                    ]
                ]);
                
            }                        
                        
            return response()->json(['msg'=> 'Support settings updated successfully!'], 200);
        }    

    }
}
