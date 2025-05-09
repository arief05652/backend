<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSystem extends Controller
{
    public function user_by_id($id) {
        $data = DB::table('users')
            ->select(
                'id', 'first_name', 'last_name',
                'email', 'phone', 'role'
            )
            ->where('id', $id)->first();
        return response()->json(['data' => $data], 200);
    }

    public function update_user(Request $request, $id) {
        $data = $request->validate([
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20|nullable',
            'email' => 'required|string|email',
            'phone' => 'required|string|max:15',
        ]);

        DB::table('users')
            ->where('id', $id)
            ->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone']
            ]);

        return response()->json(['message' => 'Sukses update user'], 200);
    }
}
