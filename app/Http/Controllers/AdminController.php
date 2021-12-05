<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Admin::all();
        return response()->view('cms.admin.index', ['admins' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|min:3|max:30',
            'status' => 'required|boolean'
        ]);
        //

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->active = $request->get('status');
            $admin->password = 'password';
            
            $isCreated = $admin->save();

            return response()->json([
                'message' => $isCreated ? 'Admin created successfully' : 'Failed to create admin'
            ], $isCreated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
        return response()->view('cms.admin.edit', ['admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|min:3|max:30',
            'status' => 'required|boolean'
        ]);
        //

        if (!$validator->fails()) {
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->active = $request->get('status');
            
            $isUpdated = $admin->save();

            return response()->json([
                'message' => $isUpdated ? 'Admin updated successfully' : 'Failed to update admin'
            ], $isUpdated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
        $isDeleted = $admin->delete();

        if ($isDeleted) {
            return response()->json([
                'icon' => 'success',
                'title' => 'Deleted!',
                'text' => 'Admin deleted successfully',
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'icon' => 'error',
                'title' => 'Failed!',
                'text' => 'Failed to delete admin',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
