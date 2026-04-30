<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $table = 'services';
    protected $primaryKey = 'id';

    protected $fillable = [
        'service_name',
        'price',
        'status',
    ];

    /**
     * Get services for DataTable (with search, limit, offset)
     */
    public static function getServices($limit, $start, $search, $orderColumn, $orderDir)
    {
        $query = self::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query->orderBy($orderColumn, $orderDir)
                     ->offset($start)
                     ->limit($limit)
                     ->get()
                     ->toArray();
    }

    /**
     * Count filtered services (for DataTable)
     */
    public static function countFiltered($search)
    {
        $query = self::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('service_name', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        return $query->count();
    }

    /**
     * Get all services list (active only)
     */
    public static function getAllServicesList()
    {
        return self::select('id', 'service_name', 'price', 'status')
                   ->whereNull('deleted_at')
                   ->orderBy('id')
                   ->get()
                   ->toArray();
    }

    /**
     * Create a new service
     */
    public static function createService(array $data)
    {
        return self::create([
            'service_name' => $data['service_name'],
            'price'        => $data['price'],
            'status'       => $data['status'],
        ]);
    }

    /**
     * Get service by ID
     */
    public static function getById($id)
    {
        return self::where('id', $id)
                   ->whereNull('deleted_at')
                   ->first();
    }

    /**
     * Update service
     */
    public static function updateService($id, array $data)
    {
        return self::where('id', $id)->update([
            'service_name' => $data['service_name'],
            'price'        => $data['price'],
            'status'       => $data['status'],
        ]);
    }

    /**
     * Soft delete service
     */
    public static function softDeleteService($id)
    {
        return self::where('id', $id)->delete();
    }

    /**
     * Get all services ordered by created_at
     */
    public static function getAllServices()
    {
        return self::orderBy('created_at', 'ASC')->get()->toArray();
    }
}
