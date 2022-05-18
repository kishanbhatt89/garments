<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PlanController extends Controller
{

    protected $api;

    public function __construct()
    {                
        $this->middleware(['auth','role:admin']);
        $this->api = new Api(
            env('RAZOR_KEY'),
            env('RAZOR_SECRET')
        );         
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {            
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));              
    }    

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [            
            'name' => 'required|unique:plans,razor_plan_name',        
            'description' => 'required',
            'price' => 'required'            
        ]);

        if ($validator->fails()) {

            return response()->json(['data'=> $validator->errors()], 400);    

        } else {
            
            $plan = $this->api->plan->create(
                array(
                    'period' => 'yearly', 
                    'interval' => 1, 
                    'item' => array(
                        'name' => $request->get('name'),
                        'description' => $request->get('description'), 
                        'amount' => $request->get('price') * 100, 
                        'currency' => 'INR'
                    )
                )
            );

            if ($plan) {

                $newPlan = new Plan;

                $newPlan->razor_plan_id = $plan->id;
                $newPlan->razor_plan_name = $plan->item->name;
                $newPlan->razor_plan_description = $plan->item->description;
                $newPlan->razor_plan_price = $plan->item->amount / 100;
                $newPlan->razor_plan_is_active = $plan->item->active;
                $newPlan->razor_plan_created_at = Carbon::createFromTimestamp($plan->item->created_at);                

                if ($newPlan->save()){
                    return response()->json(['msg'=> 'Plan added successfully!'], 200);  
                } else {
                    return response()->json(['msg'=> 'Error in adding plan'], 400);
                }
            }

        }

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
        $totalRecords = Plan::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Plan::select('count(*) as allcount')->where('razor_plan_name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Plan::orderBy($columnName,$columnSortOrder)
        ->where('plans.razor_plan_name', 'like', '%' .$searchValue . '%')        
        ->select('plans.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();

        foreach($records as $record){
            
            $razor_plan_id = $record->razor_plan_id;
            $razor_plan_name = $record->razor_plan_name;      
            $razor_plan_price = $record->razor_plan_price;
            $razor_plan_period = $record->razor_plan_period;
            $razor_plan_is_active = $record->razor_plan_is_active;
            $razor_plan_created_at = $record->razor_plan_created_at;
            $created_at = $record->created_at->diffForHumans();
            $updated_at = $record->updated_at->diffForHumans();
    
            $data_arr[] = array(                
                "razor_plan_id" => $razor_plan_id,
                "razor_plan_name" => $razor_plan_name,
                "razor_plan_price" => $razor_plan_price,                
                "razor_plan_is_active" => $razor_plan_is_active ? '<span class="badge badge-light-success">Active</span>' : '<span class="badge badge-light-danger">Inactive</span>',
                "razor_plan_created_at" => $razor_plan_created_at,
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
