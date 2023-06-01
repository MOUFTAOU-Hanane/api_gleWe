<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProgressionModule
 * 
 * @property int $id
 * @property int $module_id
 * @property int $course_id
 * @property bool $is_finish
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Course $course
 * @property Module $module
 *
 * @package App\Models
 */
class ProgressionModule extends Model
{
	protected $table = 'progression_module';

	protected $casts = [
		'module_id' => 'int',
		'course_id' => 'int',
		'is_finish' => 'bool'
	];

	protected $fillable = [
		'module_id',
		'course_id',
		'is_finish'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function module()
	{
		return $this->belongsTo(Module::class);
	}
}
