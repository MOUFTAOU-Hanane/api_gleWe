<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating
 * 
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property int $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Course $course
 * @property User $user
 *
 * @package App\Models
 */
class Rating extends Model
{
	protected $table = 'rating';

	protected $casts = [
		'user_id' => 'int',
		'course_id' => 'int',
		'note' => 'int'
	];

	protected $fillable = [
		'user_id',
		'course_id',
		'note'
	];

	public function course()
	{
		return $this->belongsTo(Course::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
