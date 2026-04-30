<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auth_permissions_users';

    protected $fillable = [
        'user_id',
        'permission',
    ];

    /**
     * Get all permissions
     */
    public static function getAll(): array
    {
        return self::orderBy('id')->get()->toArray();
    }

    /**
     * Get user IDs for dropdown
     */
    public static function getUsers(): array
    {
        return self::select('user_id')
            ->distinct()
            ->orderBy('user_id')
            ->get()
            ->toArray();
    }

    /**
     * Check if user already has this permission
     */
    public static function permissionExists(int $userId, string $permission): bool
    {
        return self::where('user_id', $userId)
            ->where('permission', $permission)
            ->exists();
    }

    /**
     * Assign permission to user
     */
    public static function assign(int $userId, string $permission)
    {
        return self::create([
            'user_id'    => $userId,
            'permission' => $permission,
        ]);
    }

    /**
     * Delete permission by ID
     */
    public static function remove(int $id): bool
    {
        return (bool) self::where('id', $id)->delete();
    }
}
