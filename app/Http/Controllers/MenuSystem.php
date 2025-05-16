<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuSystem extends Controller
{
    public function show_menu(Request $request)  {
        $category = $request->query('category');

        if ($category){
            $data = DB::table('menus')->select('*')->where('category', '=', $category)->get();
            return response()->json($data);
        } else {
            $data = DB::table('menus')->select('*')->get();
            return response()->json($data);
        }
    }

    public function added_menu(Request $request)  {
        $body = $request->validate([
            'menu_name' => 'required|string|max:255',
            'price' => 'required',
            'picture' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string'
        ]);

        $check_avail = DB::table('menus')->select('*')
            ->where('menu_name', '=', $body['menu_name'])->first();

        if ($check_avail) {
            return response()->json(['message' => 'Nama sudah terdaftar'], 302);
        } else {
            DB::table('menus')->insert([
                'id' => Str::uuid(),
                'menu_name' => $body['menu_name'],
                'price' => $body['price'],
                'picture' => $body['picture'],
                'category' => $body['category'],
                'status' => $body['status']
            ]);

            return response()->json(['message' => 'Berhasil menambahkan menu']);
        }
    }

    public function update_menu(Request $request, $id) {
        $body = $request->validate([
            'menu_name' => 'required|string|max:255',
            'price' => 'required|integer',
            'picture' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string'
        ]);

        $menu = DB::table('menus')->where('id', '=', $id)->first();

        if (!$menu) {
            return response()->json(['message' => 'Menu tidak ada'], 404);
        } 

        DB::table('menus')->where('id', '=', $id)->update($body);

        return response()->json(['message' => 'Berhasil update menu']);
    }

    public function delete_menu(Request $request) {
        $menu_id = $request->query('menu_id');

        DB::table('menus')->where('id', '=', $menu_id)->delete();

        return response()->json(['message' => 'Menu berhasil di hapus']);
    }
}
