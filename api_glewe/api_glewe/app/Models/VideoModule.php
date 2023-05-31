<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VideoModule
 * 
 * @property int $id
 * @property int $module_id
 * @property string $video
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Module $module
 *
 * @package App\Models
 */
class VideoModule extends Model
{
	protected $table = 'video_module';

	protected $casts = [
		'module_id' => 'int'
	];

	protected $fillable = [
		'module_id',
		'video'
	];

	public function module()
	{
		return $this->belongsTo(Module::class);
	}
}
