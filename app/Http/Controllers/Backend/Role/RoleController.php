<?php

namespace App\Http\Controllers\Backend\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Access\Permission;
use App\Models\Access\Role;
use Validator;
use DB;
use App\Exceptions\GeneralException;
class RoleController extends Controller
{

    protected $roles;
    protected $permissions;
    public function __construct(Role $roles, Permission $permissions)
    {
        $this->roles = $roles;
        $this->permissions = $permissions;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->search_role != '') {
            $data = Role::SearchByKeyword($request->search_role)->with('permissions')->paginate(10);
        }else{
            $data = Role::with('permissions')->paginate(10);
        }
        return view('backend.role.index',['data'=>$data])
            ->withPermissions($this->permissions->getAllPermissions())
            ->withRoleCount($this->roles->getCount());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        if ($request->search_role != '') {
            $data = Role::SearchByKeyword($request->search_role)->with('permissions')->paginate(10);
        }else{
            $data = Role::with('permissions')->paginate(10);
        }
        return view('backend.role.index',['data'=>$data])
            ->withPermissions($this->permissions->getAllPermissions())
            ->withRoleCount($this->roles->getCount());

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
            'role_name' => 'required|unique:roles,name',     
        ];
        $messages = [
            'role_name.required'=>'Bạn chưa nhập tên Role',  
            'role_name.unique' => 'Tên Role bạn nhập đã tồn tại'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
       if ($validator->fails()) {
            // Validator fail
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $all = $request->associated_permissions == 'all' ? true : false;
            DB::transaction(function() use ($request,$all) {
                $role = new Role();
                $role->name = $request->role_name; 
                $role->all = $all;
                if ($role->save()) {
                    if (!$all) {
                        $permissions = [];
                        if (is_array($request->permissions) && count($request->permissions)) {
                            foreach ($request->permissions as $perm) {
                                if (is_numeric($perm)) {
                                    array_push($permissions, $perm);
                                }
                            }
                        }
                        $role->attachPermissions($permissions);
                    }
                    return true;
                }
                throw new GeneralException('Lỗi tạo role');
            });
        }
        return redirect()->route('admin.role.index')->with(['flash_message_succ'=>'Bạn đã thêm role thành công']);
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
        $data = Role::find($id);
        return view('backend.role.edit',['data'=>$data])->withRolePermissions($data->permissions->pluck('id')->all())
                                                ->withPermissions($this->permissions->getAllPermissions());
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
            'role_name' => 'required|unique:roles,name,'.$id,     
        ];
        $messages = [
            'role_name.required'=>'Bạn chưa nhập tên Role',  
            'role_name.unique' => 'Tên Role bạn nhập đã tồn tại'
        ];  
        $validator = Validator::make($request->all(),$rules,$messages);
       if ($validator->fails()) {
            // Validator fail
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if ($id == 1) {
                $all = true;
            } else {
                $all = $request->associated_permissions == 'all' ? true : false;

            }

            if (! isset($request->permissions))
                $request->permissions = [];

            /*if (! $all) {
                //See if the role must contain a permission as per config
                if (config('access.roles.role_must_contain_permission') && count($request->permissions) == 0) {
                    
                    throw new GeneralException('You must select at least one permission for this role.');
                }

            }*/
            $role = Role::find($id);
            $role->name = $request->role_name; 
            $role->all = $all;

            if ($role->save()) {
                //If role has all access detach all permissions because they're not needed
                if ($all) {

                    $role->permissions()->sync([]);

                } else {
                    //Remove all roles first
                    $role->permissions()->sync([]);

                    //Attach permissions if the role does not have all access
                    $permissions = [];

                    if (is_array($request->permissions) && count($request->permissions)) {

                        foreach ($request->permissions as $perm) {
                            if (is_numeric($perm)) {
                                array_push($permissions, $perm);
                            }
                        }
                    }
                    $role->attachPermissions($permissions);

                }
                return redirect()->route('admin.role.index')->with(['flash_message_succ'=>'Bạn đã cập nhật role thành công']);
            }

            throw new GeneralException('Lỗi update role');
        }
        return redirect()->route('admin.role.index')->with(['flash_message_succ'=>'Bạn đã cập nhật role thành công']);

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
        $role = Role::find($id);
        if ($id == 1) { //id is 1 because of the seeder
            throw new GeneralException('Bạn ko thể xóa role này');
        }

        //Don't delete the role is there are users associated
        if ($role->users()->count() > 0) {
            return redirect()->back()->with(['flash_message_err'=>'Roles đang có user vui lòng xóa user trước']);
            //throw new GeneralException('Roles đang có user vui lòng xóa user trước');

        }

        DB::transaction(function() use($role,$id){
            //Detach all associated roles
            $role->permissions()->sync([]);
            if ($role->delete($id)) {
                return true;
            }
            throw new GeneralException('Có lỗi xảy ra trong quá trình xóa role');
        });

        return redirect()->route('admin.role.index')->with(['flash_message_succ'=>'Bạn đã xóa role thành công']);
    }
}
