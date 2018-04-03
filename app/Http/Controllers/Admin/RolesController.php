<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Permission;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use CMS\Models\UserActions;
use CMS\Models\Action;
use CMS\Models\Role;

class RolesController extends Controller
{
    use UserActions;

    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.roles')->with(
            [
                'roles' => $roles,
                'template' => $this->adminTemplate()
            ]);
    }

    public function show(Role $role)
    {
        return view('admin.roles.show')->with(['role' => $role,'template' =>$this->adminTemplate()]);
    }

    public function deleted()
    {
        $roles = Role::all();
        return view('admin.roles.roles')->with(
            [
                'roles' => $roles,
                'template' => $this->adminTemplate()
            ]);
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create')->with(['template'=>$this->adminTemplate(),'permissions' => $permissions]);
    }
    /**
     * Create a new role instance after a valid registration.
     *
     * @param  array  $data
     * @return Role
     */
    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|min:4',
        ]);

        $role = new Role($r->all());
        $role->save();

        $permissions = $r['permissions'];

        // Save selected tags, if all are deselected , detach all relations else sync selected
        (!is_array($permissions)) ? $role->permissions()->detach() : $role->permissions()->sync($permissions);

        return redirect()->action('Admin\RolesController@index');

    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $currentPermissions = $role->permissions->pluck('permission_id')->toArray();
        return view('admin.roles.create')->with(['role'=>$role,'permissions' => $permissions,'currentPermissions' => $currentPermissions,'template' =>$this->adminTemplate()]);
    }
    public function update(Request $r,Role $role)
    {

        $this->validate($r, [
            'name' => 'required|min:4',
        ]);

        $role->update($r->all());

        $permissions = $r['permissions'];

        // Save selected tags, if all are deselected , detach all relations else sync selected
        (!is_array($permissions)) ? $role->permissions()->detach() : $role->permissions()->sync($permissions);

        return redirect()->action('Admin\RolesController@index');
    }

    public function action(Request $r)
    {
        $this->Actions(new Role(),$r);
        return back();
    }

    public function destroy($id)
    {
        $roles = Role::findOrFail($id);
        Role::destroy($roles->id());

        return back();
    }

    public function hide($id)
    {
        Action::hide(new Role(),$id);
        return back();
    }

    public function approve($id)
    {
        Action::approve(new Role(),$id);
        return back();
    }

    public function trash($id)
    {
        Action::trash(new Role(),$id);
        return back();
    }
}