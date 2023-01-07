<?php

namespace App\Models\Access;

use Illuminate\Database\Eloquent\Model;
use App\Models\Access\RoleAccess;
use App\Models\Access\RoleRelationship;

/**
 * Class Role
 * @package App\Models\Access\Role
 */
class Role extends Model
{
    use RoleAccess, RoleRelationship;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'all', 'sort'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.roles_table');
    }

    public function getAllRoles($order_by = 'sort', $sort = 'asc', $withPermissions = false)
    {
        if ($withPermissions) {
            return Role::with('permissions')
                ->orderBy($order_by, $sort)
                ->get();
        }

        return Role::orderBy($order_by, $sort)
            ->get();
    }
    public function getCount() {
        return Role::count();
    }

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("name", "LIKE","%$keyword%");
                    
            });
        }
        return $query;
    }

}
