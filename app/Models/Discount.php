<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'discounts';

    protected $fillable = [
        'discount_type',
        'discount_name',
        'value',
        'start_date',
        'end_date',
        'status',
    ];

    public static function getDiscounts($limit, $offset, $search, $orderColumn, $orderDir)
    {
        $query = self::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('discount_type', 'like', "%{$search}%")
                  ->orWhere('discount_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query->orderBy($orderColumn, $orderDir)
                     ->offset($offset)
                     ->limit($limit)
                     ->get()
                     ->toArray();
    }

    public static function countFiltered($search)
    {
        $query = self::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('discount_type', 'like', "%{$search}%")
                  ->orWhere('discount_name', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query->count();
    }

    /**
     * Find single discount by ID
     */
    public static function getDiscountById(int $id)
    {
        return self::select([
                'id',
                'discount_type',
                'discount_name',
                'value',
                'start_date',
                'end_date',
                'status',
            ])
            ->where('id', $id)
            ->first();
    }

    /**
     * Create new discount
     */
    public static function createDiscount(array $data)
    {
        return self::create([
            'discount_type' => $data['discount_type'],
            'discount_name' => $data['discount_name'],
            'value'         => $data['value'],
            'start_date'    => $data['start_date'],
            'end_date'      => $data['end_date'],
            'status'        => $data['status'],
        ]);
    }

    /**
     * Update discount
     */
    public static function updateDiscount(int $id, array $data)
    {
        return self::where('id', $id)->update([
            'discount_type' => $data['discount_type'],
            'discount_name' => $data['discount_name'],
            'value'         => $data['value'],
            'start_date'    => $data['start_date'],
            'end_date'      => $data['end_date'],
            'status'        => $data['status'],
        ]);
    }

    /**
     * Soft delete discount
     */
    public static function softDeleteDiscount(int $id)
    {
        return self::where('id', $id)->delete();
    }
}
