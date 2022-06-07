<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Client;
use App\Models\Designation;
use App\Models\State;
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
        $clients = Client::with(['clientDetails'])->get();
        
        return view('admin.clients.index', compact('clients'));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:clients',            
            'password' => 'required|min:6|confirmed',            
            'address' => 'required'    
        ]);        

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $client = new Client();

        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->password = bcrypt($request->password);                

        $client->save();        

        $client->clientDetails()->create([            
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
        $client = Client::with(['clientDetails'])
                ->where('id',$request->get('id'))
                ->first();                           

        $contents = View::make('admin.clients.partials._edit', ['client' => $client])->render();
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 ); 
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
            'state' => 'required|not_in:0',
            'city' => 'required|not_in:0',
            'mobile' => 'required',            
            'address' => 'required'    
        ]);        

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }
        
        $client = User::find($request->get('id'));
        
        $client->name = $request->name;
        $client->email = $request->email;        
        $client->state_id = $request->state;
        $client->city_id = $request->city;
        
        $client->save();        

        $client->clientDetails()->update([
            'mobile' => $request->mobile,            
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
         $totalRecords = Client::select('count(*) as allcount')->count();
         $totalRecordswithFilter = Client::select('count(*) as allcount')->where('first_name', 'like', '%' .$searchValue . '%')->orWhere('last_name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Client::orderBy($columnName,$columnSortOrder)
        ->where('clients.first_name', 'like', '%' .$searchValue . '%')        
        ->orWhere('clients.last_name', 'like', '%' .$searchValue . '%')        
        ->select('clients.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            
            $id = $record->id;
            $first_name = $record->first_name;            
            $last_name = $record->last_name;            
            $email = $record->email;
            $phone = $record->phone;  
            $status = ($record->is_active == 1) ? 'Active' : 'Block';          
            $created_at = $record->created_at->diffForHumans();                

            $data_arr[] = array(
                "id" => $id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $email,
                "phone" => $phone,       
                "is_active" => $status,                                
                "created_at" => $created_at                    
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

        


        // $users = User::all();
        
        // print_r($request->get('draw'));
        // exit;
        //return response()->json($users);
    }

    public function details($id)
    {
        $client = Client::find($id);
        return view('admin.clients.partials._details', compact('client'));
    }

    public function updateStatus($id)
    {
        $client = Client::where('id', $id)->first();
        $client->is_active = !$client->is_active;

        if ($client->save()) {
            return response()->json(['msg'=> 'Client status updated successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in updating client status'], 400);
    }

}
