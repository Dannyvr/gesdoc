<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HomeTrait;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;
use App\Notification;

class DepartmentController extends Controller
{

    use HomeTrait;
    /*
    |--------------------------------------------------------------------------
    | Department Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling the departments' resources. That 
    | includes listening, showing, storing, creating and updating
    |
    */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $username = Auth::user()->username;
        $permissions = Auth::user()->role->permissions;
        $permissionsArray = $permissions->pluck('id')->toArray();

        if(in_array(3, $permissionsArray)){ // permission to see the department administration
            $departments = Department::all();
            $notifications = Notification::where('username', '=', $username)->get();
            return view('departments.index', compact('departments','notifications'));
        }
        return $this->home();
    }

        /**
     * Display a table of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function refresh()
    {
        $username = Auth::user()->username;
        $departments = Department::all();
        $notifications = Notification::where('username', '=', $username)->get();
        return view('departments.table', compact('departments','notifications'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param bool $create
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data,$create)
    {
        $validacion = [           
            'description' => ['required', 'string', 'max:500'],
        ];
        if(!$create){
            $validacion['id']=['required', 'int'];
        }

        return Validator::make($data, $validacion);
    }
    /**
     * transform an array to string
     * @param array $create
     * @return String     
     */  
    protected function myArray(array $dato)
    {    
        $arryString="'".$dato['description']."'";     
        return $arryString;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all(),true)->validate();
        $dato = request()->except(['_token']);
        $dato=$this->myArray($dato);  
        DB::select("call insert_department($dato,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']==3)  throw new DecryptException('El departamento ya existe en la base de datos');
        if($res[0]['res']!=0)  throw new DecryptException('Error en la base de datos');
        return $this->refresh();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $Department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
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
    public function update(Request $request, $id)
    {
        $this->validator($request->all(),false)->validate();
        $dato = request()->except(['_token','_method']);
        $id = $dato['id'];
        $dato=$this->myArray($dato);  
        DB::select("call update_department($id,$dato,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::select("call delete_department($id,@res)");
        $res=DB::select("SELECT @res as res;");
        $res = json_decode(json_encode($res), true);
        if($res[0]['res']!=0)  throw new DecryptException('error en la base de datos');
        return $this->refresh();
    }
}
