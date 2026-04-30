<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rooms';

    protected $fillable = [
        'room_number',
        'floor',
        'beds',
        'max_guests',
        'hotel_id',
        'status',
    ];

    public static function getRooms($limit, $offset, $search = '', $orderColumn = 'id', $orderDir = 'ASC')
    {
        $query = self::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                  ->orWhere('floor', 'like', "%{$search}%")
                  ->orWhere('beds', 'like', "%{$search}%")
                  ->orWhere('max_guests', 'like', "%{$search}%");
            });
        }

        return $query->orderBy($orderColumn, $orderDir)
                     ->offset($offset)
                     ->limit($limit)
                     ->get()
                     ->toArray();
    }

    public static function countAllRooms()
    {
        return self::count();
    }

    public static function countFilteredRooms($search = '')
    {
        $query = self::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                  ->orWhere('floor', 'like', "%{$search}%")
                  ->orWhere('beds', 'like', "%{$search}%")
                  ->orWhere('max_guests', 'like', "%{$search}%");
            });
        }

        return $query->count();
    }

    /**
     * Get all rooms including deleted
     */
    public static function getAll()
    {
        // Eloquent's get() only gets non-deleted by default, matching CI4's findAll() behavior with $useSoftDeletes = true
        return self::all()->toArray();
    }

    /**
     * Get room by ID
     */
    public static function getRoomById($id)
    {
        return self::where('id', $id)->first();
    }

    /**
     * Create new room
     */
    public static function createRoom($data)
    {
        return self::create($data);
    }

    /**
     * Update room
     */
    public static function updateRoom($id, $data)
    {
        return self::where('id', $id)->update([
            'room_number' => $data['room_number'],
            'floor'       => $data['floor'],
            'beds'        => $data['beds'],
            'max_guests'  => $data['max_guests'],
            'status'      => $data['status'],
        ]);
    }

    /**
     * Soft delete room
     */
    public static function softDeleteRoom($id)
    {
        return self::where('id', $id)->delete();
    }

    /**
     * Get all hotels (id, hotel_name) for dropdowns
     */
    public static function getAllHotels()
    {
        return DB::table('hotels')
            ->select('id', 'hotel_name')
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }
}
