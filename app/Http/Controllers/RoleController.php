<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('roles.index', [
            'roles' => Role::orderBy('id', 'DESC')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create', [
            'permissions' => Permission::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate(
            [
                'name'          => 'required|min:3|max:50|unique:roles,name',

            ],
            [
                'name.required' => 'اسم الصلاحية 
                    مطلوب',
                'name.min'      => 'اسم الصلاحية يجب أن يكو
                    ب 3 حرفًا على الأقل',
                'name.max'      => 'اسم الصلاحية يجب أن يك
                    ب 50 حرفًا على الأكثر',
                'name.unique'   => 'اسم الصلاحية مستخدم بال
                    فعل',


            ]
        );
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
            ->withSuccess('.تم اضافة الصلاحية بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        $rolePermissions = Permission::join("role_has_permissions", "permission_id", "=", "id")
            ->where("role_id", $role->id)
            ->select('name')
            ->get();
        return view('roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {

        if ($role->name == 'Super Admin') {
            abort(403, 'لا يمكن تعديل دور المشرف المتميز');
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_id", $role->id)
            ->pluck('permission_id')
            ->all();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate(
            [
                'name' => 'required|min:3|max:50|unique:roles,name,' . $role->id,

            ],
            [
                'name.required' => 'اسم الصلاحية 
                    مطلوب',
                'name.min'      => 'اسم الصلاحية يجب أن يكو
                    ب 3 حرفًا على الأقل',
                'name.max'      => 'اسم الصلاحية يجب أن يك
                    ب 50 حرفًا على الأكثر',
                'name.unique'   => 'اسم الصلاحية مستخدم من قبل',


            ]
        );
        $input = $request->only('name');

        $role->update($input);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        $role->syncPermissions($permissions);

        return redirect()->back()
            ->withSuccess('.تم تعديل الصلاحية بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name == 'Super Admin') {
            abort(403, 'لا يمكن حذف دور المشرف المتميز');
        }
        if (auth()->user()->hasRole($role->name)) {
            abort(403, 'لا يمكن حذف الدور المعين ذاتيًا');
        }
        $role->delete();
        return redirect()->route('roles.index')
            ->withSuccess('.تم حذف الصلاحية بنجاح');
    }
}
