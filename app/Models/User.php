<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;
    
    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Alias for hasRole
     */
    public function hasRoles($role)
    {
        return $this->hasRole($role);
    }

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'status',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: User has one UserInfo
     */
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id');
    }

    public function scopeGetUsers($query, int $limit, int $offset, string $search = '', string $orderColumn = 'id', string $orderDir = 'ASC')
    {
        $builder = DB::table('users as u')
            ->select('u.id', 'u.username', 'u.name', 'u.email')
            ->whereNull('u.deleted_at');

        if (!empty($search)) {
            $builder->where(function ($q) use ($search) {
                $q->where('u.username', 'like', "%{$search}%")
                  ->orWhere('u.name', 'like', "%{$search}%")
                  ->orWhere('u.email', 'like', "%{$search}%");
            });
        }

        return $builder->orderBy($orderColumn, $orderDir)
                       ->offset($offset)
                       ->limit($limit)
                       ->get()
                       ->toArray();
    }

    /**
     * Count all active users
     */
    public static function countAllUsers(): int
    {
        return self::whereNull('deleted_at')->count();
    }

    public static function countFilteredUsers(string $search = ''): int
    {
        $builder = DB::table('users as u')
            ->whereNull('u.deleted_at');

        if (!empty($search)) {
            $builder->where(function ($q) use ($search) {
                $q->where('u.username', 'like', "%{$search}%")
                  ->orWhere('u.name', 'like', "%{$search}%")
                  ->orWhere('u.email', 'like', "%{$search}%");
            });
        }

        return $builder->count();
    }

    public static function createUser(array $data): int
    {
        if (empty($data['email'])) {
            throw new \InvalidArgumentException('Email is required');
        }

        return DB::transaction(function () use ($data) {
            $userId = DB::table('users')->insertGetId([
                'username'   => $data['username'] ?? '',
                'name'       => $data['name'] ?? trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                'email'      => $data['email'],
                'password'   => $data['password'],
                'status'     => 1,
                'role'       => $data['role'] ?? 'user',
                'created_at' => now(),
            ]);

            return $userId;
        });
    }

    public static function updateUserWithInfo(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            DB::table('users')->where('id', $id)->update([
                'username'   => $data['username'] ?? '',
                'name'       => $data['name'] ?? trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                'email'      => $data['email'],
                'role'       => $data['role'] ?? 'user',
                'updated_at' => now(),
            ]);

            return true;
        });
    }

    public static function getUserWithInfo(int $id): ?object
    {
        return DB::table('users as u')
            ->select('u.id', 'u.username', 'u.name', 'u.email')
            ->where('u.id', $id)
            ->first();
    }

    /**
     * Soft delete user
     */
    public static function softDeleteUser(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            self::where('id', $id)->delete();
            return true;
        });
    }

}
