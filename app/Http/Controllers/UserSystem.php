<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSystem extends Controller
{
    public function show_user(Request $request) {
        $id = $request->query('id');

        $data = DB::table('users')
            ->select(
                'id', 'first_name', 'last_name',
                'email', 'phone', 'role'
            )
            ->where('id', '=', $id)->first();
        return response()->json($data, 200);
    }

    public function update_user(Request $request) {
        $data = $request->validate([
            'id' => 'required|string',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20|nullable',
            'email' => 'required|string|email',
            'phone' => 'required|string|max:15',
        ]);

        DB::table('users')
            ->where('id', '=', $data['id'])
            ->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone']
            ]);

        return response()->json(['message' => 'Sukses update user'], 200);
    }

    public function update_role(Request $request) {
        $data = $request->validate([
            'id' => 'string|required',
            'role' => 'required|string'
        ]);

        DB::table('users')
            ->where('id', '=', $data['id'])
            ->update(['role' => $data['role']]);
        
        return response()->json(['message' => 'Sukses update role user']);
    }
}
