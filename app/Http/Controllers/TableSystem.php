<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableSystem extends Controller
{
    public function show_table(Request $request) {
        $valid = $request->validate([
            'status' => 'string|max:20'
        ]);

        $status = $valid['status'] ?? null;

        if ($status !== null) {
            $data = DB::table('table')  
                ->select('id', 'code', 'capacity', 'status')
                ->where('status', '=', $status)
                ->get();
            if ($data->isEmpty()){
                return response()->json(['message' => 'Tidak ada data'], 404);
            }
        } else {
            $data = DB::table('table')  
                ->select('id as table_id', 'code', 'capacity', 'status')
                ->select('id', 'code', 'capacity', 'status')
                ->get();
            if ($data->isEmpty()){
                return response()->json(['message' => 'Tidak ada data'], 404);
            }
        }
        return $data;
    }

    public function add_table(Request $request) {
        $valid = $request->validate([
            'code' => 'required|string|max:20',
            'capacity' => 'required|integer|min:1',
        ]);

        $check_code = DB::table('table')
            ->select('code')
            ->where('code', '=', $valid['code'])
            ->get();

        if ($check_code->isEmpty()) {
            DB::table('table')
                ->insert([
                    'id' => Str::uuid(),
                    'code' => $valid['code'],
                    'capacity' => $valid['capacity']
                ]);
            return response()->json([
                'message' => 'Berhasil mendaftarkan meja'
            ]);
        } else {
            return response()->json([
                "message" => "Code tersebut sudah terdaftar"
            ], 302);
        }
    }

    public function update_table(Request $request) {
        $data = $request->validate([
            'id' => 'required|string',
            'code' => 'string|required|max:20',
            'capacity' => 'integer|required|min:1',
            'status' => 'required|string'
        ]);

        DB::table('table')
            ->where('id', '=', $data['id'])
            ->update([
                'code' => $data['code'],
                'capacity' => $data['capacity'],
                'status' => $data['status']
            ]);

        return response()->json([
            'message' => 'Berhasil update table'
        ]);
    }

    public function delete_table($id) {
        DB::table('table')
            ->where('id', '=', $id)
            ->delete();
        return response()->json(['message' => 'Sukses menghapus table']);
    }
}
