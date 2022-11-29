<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chart;
use App\Models\Menu;
use App\Models\User;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id_menu)
    {
        $menuchart = Menu::find($request->id_menu);
        $user = User::find($request->id_user);
        if ($menuchart) {
            $chart = new Chart();
            $chart->id_user = $request->input('id_user');
            $chart->id_menu = $request->input('id_menu');
            $chart->name_menu = $menuchart->name_menu;
            $chart->size_menu = $menuchart->size_menu;
            $chart->price_menu = $menuchart->price_menu;
            $chart->quantity_order = $request->input('quantity_order');
            $chart->amount = $request->quantity_order * $menuchart->price_menu;
            $chart->save();

            $hasilpost = ['chart_menu' => $chart, 'detail_menu' => $menuchart];

            return response()->json([
                'success'   => 201,
                'message'   => 'Menu successfully added to cart',
                'data'      => $hasilpost
            ], 201);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id menu ' . $request->id_menu . ' does not exist'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_user)
    {
        $chartmenu = Chart::where('id_user', $id_user)->get();
        if ($chartmenu) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Menu found',
                'data'      => $chartmenu
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id user ' . $id_user . ' does not exist'
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
        $menu = Chart::find($id);
        if ($user->id == $menu->id_user) {
            $chartmenu = Chart::where('id', $id)->first();
            $menuchart = Menu::find($chartmenu->id_menu);
            if ($chartmenu) {
                $chartmenu->quantity_order = $request->quantity_order ? $request->quantity_order : $chartmenu->quantity_order;
                $chartmenu->amount = $request->quantity_order ? $request->quantity_order * $menuchart->price_menu : $chartmenu->amount;
                $chartmenu->save();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Menu updated successfully',
                    'data'      => $chartmenu
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id' . $chartmenu . 'coul not found'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'This is not the menu in your cart'
            ], 401);
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
        $menu = Chart::find($id);
        if ($user->id == $menu->id_user) {
            $chartmenu = Chart::where('id', $id)->first();
            if ($chartmenu) {
                $chartmenu->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Menu are deleted from your cart',
                    'data'      => $chartmenu
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id' . $chartmenu . 'could not found'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'This is not the menu in your cart'
            ], 401);
        }
    }
}
