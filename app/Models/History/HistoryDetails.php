<?php namespace App\Models\History;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class History
 * package App
 */
class HistoryDetails extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'history_details';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['history_id', 'order_id', 'order_status', 'room_id', 'status_changed', 'timestamp_process'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function type() {
		return $this->hasOne(History::class, 'id', 'history_id');
	}
}