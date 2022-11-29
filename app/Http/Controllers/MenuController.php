<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\User;
use App\Models\MenuCategory;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::all();
        return $menu;
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
            // 
            $images_menu = $request->images_menu;
            $image = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $images_menu));

            //
            $image_name = "images-menu-file-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $filename = $image_name . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('data_images_menu/');
            //image uploading folder path
            file_put_contents($path . $filename, $image);

            // 
            $post_image = 'data_images_menu/' . $filename;

            $menu = new Menu();
            $menu->id_category = $request->input('id_category');
            $menu->images_menu = $post_image;
            $menu->name_menu = $request->input('name_menu');
            $menu->size_menu = $request->input('size_menu');
            $menu->price_menu = $request->input('price_menu');
            $menu->quantity_menu = $request->input('quantity_menu');
            $menu->satuan_menu = $request->input('satuan_menu');
            $menu->save();

            $categorymenu = MenuCategory::where('id', $request->id_category)->first();

            return response()->json([
                'success'   => 201,
                'message'   => 'data has been successfull',
                'data'      => $menu, 'category_menu' => $categorymenu->menu_category
            ], 201);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'You are not an admin'
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
        $menu = Menu::where('id_category', $id)->orderBy('updated_at', 'DESC')
        ->get();
        if ($menu) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data found',
                'data'      => $menu
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id ' . $id . ' could not be found'
            ], 404);
        }
    }
    public function searchmenu($name_menu)
    {
        return response()->json([
            'message' => 'Data found',
            'data' => Menu::orderBy('created_at', 'DESC')
                ->where('name_menu', 'LIKE', '%' . $name_menu . '%')
                ->get()
        ], 200);
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
    public function update(Request $request, $id)
    {
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $menu = Menu::find($id);
            if ($menu) {
                if ($request->images_menu != '') {
                    $images_menu = $request->images_menu;
                    $image = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $images_menu));

                    //
                    $image_name = "images-menu-file-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
                    $filename = $image_name . '.' . 'jpg';
                    //rename file name with random number
                    $path = public_path('data_images_menu/');
                    //image uploading folder path
                    file_put_contents($path . $filename, $image);

                    // 
                    $post_image = 'data_images_menu/' . $filename;

                    $menu->id_category = $request->id_category ? $request->id_category : $menu->id_category;
                    $menu->name_menu = $request->name_menu ? $request->name_menu : $menu->name_menu;
                    $menu->images_menu = $post_image ? $post_image : $menu->images_menu;
                    $menu->size_menu = $request->size_menu ? $request->size_menu : $menu->size_menu;
                    $menu->price_menu = $request->price_menu ? $request->price_menu : $menu->price_menu;
                    $menu->quantity_menu = $request->quantity_menu ? $request->quantity_menu : $menu->quantity_menu;
                    $menu->satuan_menu = $request->satuan_menu ? $request->satuan_menu : $menu->satuan_menu;
                    $menu->save();
                } else {
                    $menu->id_category = $request->id_category ? $request->id_category : $menu->id_category;
                    $menu->name_menu = $request->name_menu ? $request->name_menu : $menu->name_menu;
                    $menu->images_menu = $menu->images_menu;
                    $menu->size_menu = $request->size_menu ? $request->size_menu : $menu->size_menu;
                    $menu->price_menu = $request->price_menu ? $request->price_menu : $menu->price_menu;
                    $menu->quantity_menu = $request->quantity_menu ? $request->quantity_menu : $menu->quantity_menu;
                    $menu->satuan_menu = $request->satuan_menu ? $request->satuan_menu : $menu->satuan_menu;
                    $menu->save();
                }

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data has been successfull',
                    'data'      => $menu
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id ' . $id . ' could not be found'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'You are not an admin'
            ], 404);
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
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $menu = Menu::where('id', $id)->first();
            if ($menu) {
                $menu->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data deleted successfully',
                    'data'      => $menu
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id ' . $id . ' could not be found'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'You are noy an admin'
            ], 404);
        }
    }
}
