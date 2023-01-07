<?php namespace App\Models\History;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Auth;
/**
 * Class History
 * package App
 */
class HistoryStore extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'history_store';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['type_id', 'user_id', 'entity_id', 'email', 'name', 'text', 'content'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function user() {
		return $this->hasOne(User::class, 'id', 'user_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function type() {
		return $this->hasOne(HistoryStoreType::class, 'id', 'type_id');
	}

	public function log($type,$entity_id = null, $text = null, $content = null,  $icon = null, $class = null, $assets = null){
		//Type can be id or name
		/*if (!is_numeric($type))
			$type = HistoryStoreType::where('name', $type)->first();

		if ($type instanceof HistoryStoreType)
			return History::create([
				'type_id' => $type->id,
				'text' => $text,
				'user_id' => access()->id(),
				'entity_id' => $entity_id,
				'icon' => $icon,
				'class' => $class,
				'assets' => is_array($assets) && count($assets) ? json_encode($assets) : null,
			]);

		return false;*/
		return HistoryStore::create([
			'type_id' => $type,//$type->id,
			'text' => $text,
			'content' => $content,
			'user_id' =>  Auth::user()->id,
			'email' => Auth::user()->email,
			'name' => Auth::user()->name,
			'entity_id' => $entity_id,
			'icon' => $icon,
			'class' => $class,
			'assets' => is_array($assets) && count($assets) ? json_encode($assets) : null,
		]);

		return false;
	}
	
}