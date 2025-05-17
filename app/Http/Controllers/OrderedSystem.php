<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderedSystem extends Controller
{
    public function make_order(Request $request) {
        $body = $request->validate([
            'user_id' => 'required|string',
            'data' => 'required|array',
            'data.*.menu_id' => 'required|string',
            'data.*.quantity' => 'required|integer|min:1',
            'data.*.notes' => 'required|string|max:255',

        ]);

        $user_id = $body['user_id'];
        $orders = [];

        foreach ($body['data'] as $ordered) {
            $orders[] = [
                'id' => Str::uuid(),
                'user_id' => $user_id,
                'menu_id' => $ordered['menu_id'],
                'quantity' => $ordered['quantity'],
                'notes' => $ordered['notes']
            ];
        }

        DB::table('order')->insert($orders);

        return response()->json(['message' => 'Berhasil order pesanan']);
    }

    public function show_order(Request $request) {
        $user_id = $request->query('user_id');

        $user = DB::table('users')->select('users.id', 'first_name', 'last_name', 'email')
            ->where('users.id', '=', $user_id)->first();


        $data = DB::table('order')->where('order.user_id', '=', $user_id)
            ->join('menus', 'menus.id', '=', 'order.menu_id')
            ->select(
                'order.id as order_id',
                'menus.menu_name',
                'menus.picture',
                'menus.price',
                'order.quantity',
                'order.notes',
                'order.status',
                'order.order_at'
            )->get();

        return response()->json([
            'user' => [
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email
            ],
            'orders' => $data
        ]);
    }
}
