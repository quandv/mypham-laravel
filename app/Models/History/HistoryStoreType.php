<?php namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

/**
 * Class HistoryType
 * package App
 */
class HistoryStoreType extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'history_store_types';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];
}