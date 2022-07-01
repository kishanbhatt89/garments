<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    
    public function __construct() 
    {
        $this->middleware(['auth','role:admin']); 
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function add()
    {
        $categories = Category::all();
        return view('admin.categories.add', compact('categories'));
    }

    public function show(Request $request)
    {
        $category = Category::where('id',$request->get('id'))->first();            
        $categories = Category::where('id','!=',$request->get('id'))->get();
        $contents = View::make('admin.categories.partials._edit', ['category' => $category, 'categories' => $categories]);
        
        $response = Response::make($contents, 200);                
        
        return response()->json(['data'=> $response->content()], 200 );        
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'parent_id' => 'nullable|integer',
        ]);

        $uploadFolder = 'categories';

        $image = $request->file('image');

        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $category = new Category();

        $category->name = $request->name;
        $category->parent_id = $request->parent_id ? $request->parent_id : 0;
        $category->slug = $request->slug;        
        $category->image = basename($image_uploaded_path);

        if ($category->save()) {
            return redirect()->back()->with('success', 'Category added successfully!');
        }

        return redirect()->back()->with('error', 'Error in adding category!');

        // if ($validator->fails()) {
        //     return response()->json(['data'=> $validator->errors()], 400);    
        // }
        
        // if (Category::create(['name' => $request->name, 'parent_id' => ($request->parent_id ? $request->parent_id : 0), 'slug' => $request->slug]))
        // {
        //     return response()->json(['msg'=> 'Category added successfully!'], 200);    
        // }

        // return response()->json(['msg'=> 'Error in adding category'], 200);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,id,'.$request->id.',id',
            'slug' => 'required|unique:categories,id,'.$request->id.',id',
            'parent_id' => 'nullable|integer',       
        ]);   

        if ($validator->fails()) {
            return response()->json(['data'=> $validator->errors()], 400);    
        }

        $category = Category::find($request->id);
        
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_id = $request->parent_id ? $request->parent_id : 0;

        if($category->save()) 
        {
            return response()->json(['msg'=> 'Category updated successfully! '], 200);    
        } 

        return response()->json(['msg'=> 'Error in updating category'], 200);
    }

    public function destroy(Request $request)
    {
        $category = Category::where('name', $request->get('category'))->first();
        
        if ($category->delete()) {
            return response()->json(['msg'=> 'Category deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting category'], 400);
    }

    public function destroyMultiple(Request $request)
    {                        
        if (Category::destroy($request->get('categories'))) {
            return response()->json(['msg'=> 'Selected categories deleted successfully!'], 200);
        }

        return response()->json(['msg'=> 'Error in deleting selected categories'], 400);
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
        $totalRecords = Category::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Category::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Category::orderBy($columnName,$columnSortOrder)
        ->where('categories.name', 'like', '%' .$searchValue . '%')        
        ->select('categories.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();        

        $data_arr = array();

        foreach($records as $record){
            
            $id = $record->id;
            $name = $record->name;
            $slug = $record->slug;
            $parent = isset($record->parent->name) ? $record->parent->name : '';  
            $created_at = $record->created_at->diffForHumans();
            $updated_at = $record->updated_at->diffForHumans();
    
            $data_arr[] = array(
              "id" => $id,
              "name" => $name,               
              "slug" => $slug,
              "parent" => $parent,   
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
