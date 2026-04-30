<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'guest_id',
        'hotel_code',
        'hotel_id',
        'room_id',
        'discount_id',
        'check_in',
        'check_out',
        'status',
    ];

    /** Get all reservations optionally filtered by user */
    public static function getReservations($start = 0, $length = 10, $search = '', $orderColumn = 'r.id', $orderDir = 'ASC')
    {
        $query = DB::table('reservations as r')
            ->select(
                'r.id', 'r.hotel_code', 'r.room_id', 'r.check_in', 'r.check_out', 'r.status',
                'u.email as email', 'h.hotel_name', 'd.discount_name'
            )
            ->leftJoin('users as u', 'r.user_id', '=', 'u.id')
            ->leftJoin('hotels as h', 'r.hotel_id', '=', 'h.id')
            ->leftJoin('discounts as d', 'r.discount_id', '=', 'd.id')
            ->whereNull('r.deleted_at');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('r.hotel_code', 'like', "%{$search}%")
                  ->orWhere('u.email', 'like', "%{$search}%")
                  ->orWhere('h.hotel_name', 'like', "%{$search}%")
                  ->orWhere('d.discount_name', 'like', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();

        $data = $query->orderBy($orderColumn, $orderDir)
                      ->offset($start)
                      ->limit($length)
                      ->get()
                      ->toArray();

        return ['data' => $data, 'recordsFiltered' => $totalFiltered];
    }

    public static function countAllReservations()
    {
        return self::count();
    }

    public static function getReservationById($id)
    {
        return DB::table('reservations as r')
            ->select('r.*', 'u.email as email', 'h.hotel_name', 'd.discount_name')
            ->leftJoin('users as u', 'r.user_id', '=', 'u.id')
            ->leftJoin('hotels as h', 'r.hotel_id', '=', 'h.id')
            ->leftJoin('discounts as d', 'r.discount_id', '=', 'd.id')
            ->where('r.id', $id)
            ->whereNull('r.deleted_at')
            ->first();
    }

    /** Insert new reservation */
    public static function createReservation(array $data)
    {
        return self::create($data);
    }

    /** Update reservation by ID */
    public static function updateReservation($id, array $data)
    {
        return self::where('id', $id)->update($data);
    }

    /** Soft delete reservation by ID */
    public static function softDeleteById($id)
    {
        return self::where('id', $id)->delete();
    }

    /** Get all rooms (active only) */
    public static function getAllRooms()
    {
        return DB::table('rooms')
            ->select('id')
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }
}
