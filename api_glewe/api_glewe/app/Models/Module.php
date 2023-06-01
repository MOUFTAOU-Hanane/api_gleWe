<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Module
 * 
 * @property int $id
 * @property int $course_id
 * @property string $name
 * @property string $duration
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Course $course
 * @property Collection|ProgressionModule[] $progression_modules
 * @property Collection|VideoModule[] $video_modules
 *
 * @package App\Models
 */
class Module extends Model
{
	protected $table = 'modules';

	protected $casts = [
		'course_id' => 'int'
	];

	protected $fillable = [
		'course_id',
		'name',
		'duration'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function progression_modules()
	{
		return $this->hasMany(ProgressionModule::class);
	}

	public function video_modules()
	{
		return $this->hasMany(VideoModule::class);
	}
}
