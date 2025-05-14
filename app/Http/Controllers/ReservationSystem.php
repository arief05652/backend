<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationSystem extends Controller
{
    public function add_reserve(Request $request) {
        $body = $request->validate([
            "user_id" => "required|string",
            "table_id" => "required|string",
            "notes" => "string|nullable",
            "schedule" => "date|required",
            "capacity" => "required|integer"
        ]); 

        $validasi_capacity = DB::table('table')
            ->where('id', '=', $body['table_id'])
            ->select('capacity')
            ->first();

        if ($body['capacity'] <= $validasi_capacity->capacity) {
            DB::table('reservation')
            ->insert([
                'id' => Str::uuid(),
                'user_id' => $body['user_id'],
                'table_id' => $body['table_id'],
                'notes' => $body['notes'],
                'schedule' => $body['schedule'],
                'capacity' => $body['capacity']
            ]);

            DB::table('table')
                ->where('id', '=', $body['table_id'])
                ->update(['status' => 'booking']);

            return response()->json(['message' => 'Sukses booking table']);
        } else {
            return response()->json(['message' => 'Kapasitas tidak mencukupi'], 403);
        }
    }

    public function check_in_reserve(Request $request) {
        $body = $request->query('reservation_id');

        $check_data = DB::table('reservation')
            ->select('id')->where('id', '=', $body['reservation_id'])
            ->get();

        if ($check_data->isEmpty()) {
            return response()->json(['message' => 'Reservation ID tidak ditemukan'], 404);
        }

        DB::table('reservation')->update([
            'status' => 'checked_in'
        ]);
        
        return response()->json(['message' => 'Reservation ID valid']);
    }

    public function show_user_reserve(Request $request) {
        $status = $request->query('status');

        if ($status === null) {
            $data = DB::table('reservation')
                ->join('users', 'users.id', '=', 'reservation.user_id')
                ->join('table', 'table.id', '=', 'reservation.table_id')
                ->select(
                    'reservation.id as reservation_id',
                    'users.id as user_id',
                    'users.email', 
                    'users.phone', 
                    'table.code as table_code', 
                    'reservation.status as status_reservation',
                    'reservation.schedule as schedule_reserve', 
                    'reservation.capacity')->get(); 
            if ($data->isEmpty()) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        } else {
            $data = DB::table('reservation')->where('reservation.status', '=', $status)
                ->join('users', 'users.id', '=', 'reservation.user_id')
                ->join('table', 'table.id', '=', 'reservation.table_id')
                ->select(
                    'reservation.id as reservation_id',
                    'users.id as user_id',
                    'users.email', 
                    'users.phone', 
                    'table.code as table_code', 
                    'reservation.status as status_reservation',
                    'reservation.schedule as schedule_reserve', 
                    'reservation.capacity')->get();
            if ($data->isEmpty()) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        }
        return response()->json($data);
    }

    public function done_reservation(Request $request) {
        $reservation_id = $request->query('reservation_id');

        DB::table('reservation')->where('id', '=', $reservation_id)
            ->update(['status' => 'complete']);

        $check_data = DB::table('reservation')->where('reservation.id', '=', $reservation_id)
            ->join('table', 'table.id', '=', 'reservation.table_id')
            ->select('reservation.user_id', 'reservation.status', 'table.code', 
            'reservation.capacity', 'reservation.notes', 'reservation.reserve_at')
            ->first();
        
        DB::table('log_reservation')->insert([
            'id' => Str::uuid(),
            'user_id' => $check_data->user_id,
            'code' => $check_data->code,
            'notes' => $check_data->notes,
            'capacity' => $check_data->capacity,
            'status' => $check_data->status,
            'reserve_at' => $check_data->reserve_at
        ]);

        DB::table('table')->where('code', '=', $check_data->code)->update(['status' => 'tersedia']);
        DB::table('reservation')->where('id', '=', $reservation_id)->delete();

        return response()->json(['message' => 'Status reservasi anda telah ditutup']);
    }

    public function cancel_reservation(Request $request) {
        $reservation_id = $request->query('reservation_id');

        DB::table('reservation')->where('id', '=', $reservation_id)
            ->update(['status' => 'cancelled']);

        $check_data = DB::table('reservation')->where('reservation.id', '=', $reservation_id)
            ->join('table', 'table.id', '=', 'reservation.table_id')
            ->select('reservation.user_id', 'reservation.status', 'table.code', 
            'reservation.capacity', 'reservation.notes', 'reservation.reserve_at')
            ->first();
        
        DB::table('log_reservation')->insert([
            'id' => Str::uuid(),
            'user_id' => $check_data->user_id,
            'code' => $check_data->code,
            'notes' => $check_data->notes,
            'capacity' => $check_data->capacity,
            'status' => $check_data->status,
            'reserve_at' => $check_data->reserve_at
        ]);
        DB::table('table')->where('code', '=', $check_data->code)->update(['status' => 'tersedia']);
        DB::table('reservation')->where('id', '=', $reservation_id)->delete();

        return response()->json(['message' => 'Reservasi berhasil di cancel']);
    }

    public function show_histori_reservation(Request $request) {
        $user_id = $request->query('user_id');

        $data = DB::table('log_reservation')->select('*')
            ->where('log_reservation.user_id', '=', $user_id)->get();
        
        if ($data->isEmpty()){
            return response()->json(['message' => 'Data tidak ditemukan'], 404);    
        }
        return response()->json($data);
    }
}
