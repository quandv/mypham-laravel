<?php

namespace App\Models\Access;

use Illuminate\Database\Eloquent\Model;
use App\Models\Access\PermissionRelationship;

/**
 * Class Permission
 * @package App\Models\Access
 */
class Permission extends Model
{
    use PermissionRelationship;

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
    protected $fillable = ['name', 'display_name', 'sort'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.permissions_table');
    }
    public function getAllPermissions($order_by = 'sort', $sort = 'asc')
    {
        return Permission::orderBy($order_by, $sort)->get();
    }
}