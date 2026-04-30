<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'hotels';

    protected $fillable = [
        'hotel_name',
        'address',
        'contact_no',
    ];

    public static function getHotels($limit, $offset, $search, $orderColumn, $orderDir)
    {
        $query = self::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('hotel_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('contact_no', 'like', "%{$search}%");
            });
        }

        return $query->orderBy($orderColumn, $orderDir)
                     ->offset($offset)
                     ->limit($limit)
                     ->get()
                     ->toArray();
    }

    public static function countAllHotels()
    {
        return self::count();
    }

    public static function countFilteredHotels($search)
    {
        $query = self::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('hotel_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('contact_no', 'like', "%{$search}%");
            });
        }

        return $query->count();
    }

    /**
     * Get hotel by ID (only not deleted)
     */
    public static function getHotelById($id)
    {
        return self::where('id', $id)->first();
    }

    /**
     * Create a new hotel
     */
    public static function createHotel($data)
    {
        return self::create($data);
    }

    /**
     * Update hotel
     */
    public static function updateHotel($id, $data)
    {
        return self::where('id', $id)->update([
            'hotel_name' => $data['hotel_name'],
            'address'    => $data['address'],
            'contact_no' => $data['contact_no'],
        ]);
    }

    /**
     * Soft delete a hotel
     */
    public static function softDeleteHotel($id)
    {
        return self::where('id', $id)->delete();
    }

    /**
     * Get all hotels (including deleted if needed)
     */
    public static function getAllHotelsIncludingDeleted()
    {
        return self::withTrashed()->get()->toArray();
    }
}
