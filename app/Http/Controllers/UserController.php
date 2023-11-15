<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::where('status','=','1')->orWhere('status','=','2')->orderBy('id','DESC')->paginate(50);
        return view('users.index',compact('data'));
        /*return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);*/

            /*$variable=Tabla::whereIn('campoA', ['1','2'])
                ->orderBy('id')
                ->get();*/
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        //dd($input['user_name']);
        $input['user_name'] = $input['email'];
        $input['password'] = Hash::make($input['password']);
        //return $input;
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();    
        return view('users.edit',compact('user','roles','userRole'));
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
        /*return $request;
        return $request->input('roles')[0];*/
        //return $request->input('roles')[0];
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
      //RoleUser::where('user_id', $id)->update(array('role_id' =>$request->input('roles') ));      


      $resultQuery = User::where('name',$request['name'])->first();                
      $usr = $resultQuery->id;       

      $result = DB::connection('mysql')->update("UPDATE role_users 
      SET role_id = (SELECT id FROM roles WHERE name = ?) WHERE user_id = ?", [$request->input('roles')[0],$usr]);
                         
      return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
   
    

    public function inactivar( $id)
    {
        $Actualizar = User::findOrFail($id);            
        $Actualizar->status = 2;        
        $Actualizar->save();
             
        return redirect()->route('users.index')
                        ->with('success','Actualización Exitosa, el usuario se encuentra INACTIVO');
    }

    public function activar( $id)
    {
        $Actualizar = User::findOrFail($id);            
        $Actualizar->status = 1;        
        $Actualizar->save();
             
        return redirect()->route('users.index')
                        ->with('success','El Usuario fue ACTIVADO Exitosamente');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //User::find($id)->delete();
        $Actualizar = User::findOrFail($id);            
        $Actualizar->status = 0;        
        $Actualizar->save();
        //$user->update($Actualizar);
        return redirect()->route('users.index')
                        ->with('success','User eliminado correctamente');
    }
}