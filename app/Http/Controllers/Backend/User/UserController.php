<?php

namespace App\Http\Controllers\Backend\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Access\User;
use App\Models\Access\Role;
use Validator;
use DB;
use App\Exceptions\GeneralException;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $users;
    protected $roles;
    public function __construct(User $users, Role $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     /*   echo "<pre>";
        print_r(Auth::user()->all());
        echo "</pre>";*/
        //
        if ($request->search_user != '') {
            $data = User::SearchByKeyword($request->search_user)->with('roles')->paginate(10);
        }else{
            $data = User::with('roles')->paginate(10);
        }

        return view('backend.user.index',['data'=>$data])->withRoles($this->roles->getAllRoles('sort', 'asc', true));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($request->search_user != '') {
            $data = User::SearchByKeyword($request->search_user)->with('roles')->paginate(10);
        }else{
            $data = User::with('roles')->paginate(10);
        }
       
       // dd($this->roles->getAllRoles('sort', 'asc', true));
        return view('backend.user.index',['data'=>$data])->withRoles($this->roles->getAllRoles('sort', 'asc', true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //
        $rules = [
            'user_name'             => 'required',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ];
        $messages = [
            'user_name.required'=>'Bạn chưa nhập tên user',
            'email.required'=>'Bạn chưa nhập Email',
            'email.email'=>'Định dạng email không đúng',
            'email.unique'=>'Email đã tồn tại',
            'password.required'=>'Bạn chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' =>'Mật khẩu nhập lại chưa đúng',
            'password_confirmation.required' => 'Bạn chưa nhập lại mật khẩu'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
       if ($validator->fails()) {
            // Validator fail
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $roles=  $request->only('assignees_roles');
            $user = new User();
            $user->name = $request->user_name; 
            $user->email = $request->email; 
            $user->password = bcrypt(trim($request->password)); 
           
           DB::transaction(function() use ($user, $roles) {
            if ($user->save()) {
                //Attach new roles
                if ($roles['assignees_roles'] != null) {
                   $user->attachRoles($roles['assignees_roles']);
                }
                return true;
            }
                throw new GeneralException('Error');
            });
            /*$this->users->create(
                //$request->except('assignees_roles'),
               // $request->only('assignees_roles')
                'name'=> $request->user_name;
                'email'=> $request->email;
                'password'=>bcrypt(trim($request->password));
            );*/
            return redirect()->route('admin.user.index')->with(['flash_message_succ'=>'Bạn đã thêm user thành công']);
        }      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $roles = Role::with('permissions')->get();
        $data = User::find($id);
        $user_roles = $data->roles->pluck('id')->all();
        return view('backend.user.edit',['data'=>$data,'roles'=>$roles,'user_roles'=>$user_roles]);
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
        //
        $rules = [
            'user_name'             => 'required',
            'email'                 => 'required|email|unique:users,email,'.$id,
            'old_password'          => 'min:6',
            'password'              => 'min:6|confirmed',
            'password_confirmation' => 'min:6',
        ];
        $messages = [
            'user_name.required'=>'Bạn chưa nhập tên user',
            'email.required'=>'Bạn chưa nhập Email',
            'email.email'=>'Định dạng email không đúng',
            'email.unique'=>'Email đã tồn tại',
            'old_password.required' => 'Bạn chưa nhập password cũ',
            'password.required' =>'Bạn chưa nhập password mới',
            'password_confirmation' => 'Bạn phải xác nhận lại password mới',
            'password.confirmed' =>'Mật khẩu nhập lại chưa đúng',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password_confirmation.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password_confirmation.required' =>'Bạn chưa nhập lại mật khẩu'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
        $user = User::find($id);
        if ($request->password != '') {
            $old_pass = $request->input('old_password');
            $validator->after(function($validator) use ($old_pass,$user)  {
                if (!Hash::check($old_pass,$user->password)){
                    $validator->errors()->add('field', 'Mật khẩu cũ không chính xác !');
                }
            });
        }
       if ($validator->fails()) {
            // Validator fail
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $roles=  $request->only('assignees_roles');
            
            $user->name = $request->user_name; 
            $user->email = $request->email; 
            if ($request->password != '') {
                $user->password = bcrypt(trim($request->password)); 
            }
           DB::transaction(function() use ($user, $roles) {
            if ($user->save()) {
                $user->detachRoles($user->roles);
                //Attach new roles
                $user->attachRoles($roles['assignees_roles']);
                return true;
            }
                throw new GeneralException('Error');
            });
            /*$this->users->create(
                //$request->except('assignees_roles'),
               // $request->only('assignees_roles')
                'name'=> $request->user_name;
                'email'=> $request->email;
                'password'=>bcrypt(trim($request->password));
            );*/
            return redirect()->route('admin.user.index')->with(['flash_message_succ'=>'Bạn đã cập nhật user thành công']);
        }    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);

        $user->delete($id);

        DB::transaction(function() use ($user) {
            //Detach all roles & permissions
            $user->detachRoles($user->roles);   
            //throw new GeneralException(trans('Delete error'));
        });
        return redirect()->route('admin.user.index')->with(['flash_message_succ'=>'Bạn đã xóa user thành công']);
    }
}
