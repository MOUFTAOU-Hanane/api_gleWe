<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CoursesEnrolment
 * 
 * @property int $id
 * @property int $course_id
 * @property int $user_id
 * @property Carbon $enrolment_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Course $course
 * @property User $user
 *
 * @package App\Models
 */
class CoursesEnrolment extends Model
{
	protected $table = 'courses_enrolment';

	protected $casts = [
		'course_id' => 'int',
		'user_id' => 'int',
		'enrolment_date' => 'datetime'
	];

	protected $fillable = [
		'course_id',
		'user_id',
		'enrolment_date'
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
