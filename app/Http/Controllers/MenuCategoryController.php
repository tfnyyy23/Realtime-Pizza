<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\User;


class MenuCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = MenuCategory::all();
        return $category;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->role == 'admin') {
            $categorymenu = new MenuCategory();
            $categorymenu->menu_category = $request->input('menu_category');
            $categorymenu->save();

            return response()->json([
                'success' => 201,
                'message' => 'data has been successfully',
                'data' => $categorymenu
            ], 201);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'You are not admin'
            ], 404);
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
        $categorymenu = MenuCategory::find($id);
        if ($categorymenu) {
            return response()->json([
                'status' => 200,
                'data' => $categorymenu
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'messages' => 'id ' . $id . ' could not be found'
            ], 404);
        }
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id_user)
    {
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $categorymenu = MenuCategory::find($id);
            if ($categorymenu){
                $categorymenu->menu_category = $request->menu_category ? $request->menu_category : $categorymenu->menu_category;
            $categorymenu->save();
            return response()->json([
                'success' => 201,
                'message' => 'data has been successfully',
                'data' => $categorymenu
            ], 200);
            } else{
                return response()->json([
                    'status' => 404,
                    'message' => 'id ' . $id . ' could not be found'
                ], 404);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_user)
    {
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $categorymenu = MenuCategory::where('id', $id)->first();
            if ($categorymenu) {
                $categorymenu->delete();
                return response()->json([
                    'status' => 200,
                    'data' => $categorymenu,
                    'messages' => 'data deleted successfully'
                ],200);
            }else {
                return response()->json([
                    'status' => 404,
                    'messages' => 'id ' . $id . ' could not be found'
                ],404);
            }
        }
    }

}
