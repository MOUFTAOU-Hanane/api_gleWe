<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 * 
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $trainer_name
 * @property int $price
 * @property string $description
 * @property string|null $cover
 * @property string $course_type
 * @property int $course_level
 * @property string $estimated_duration
 * @property int $enrolled_student
 * @property int $language_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Category $category
 * @property Language $language
 * @property Collection|CoursesEnrolment[] $courses_enrolments
 * @property Collection|Module[] $modules
 * @property Collection|Quiz[] $quizzes
 * @property Collection|Rating[] $ratings
 *
 * @package App\Models
 */
class Course extends Model
{
	protected $table = 'courses';

	protected $casts = [
		'category_id' => 'int',
		'price' => 'int',
		'course_level' => 'int',
		'enrolled_student' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'name',
		'category_id',
		'trainer_name',
		'price',
		'description',
		'cover',
		'course_type',
		'course_level',
		'estimated_duration',
		'enrolled_student',
		'language_id'
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function language()
	{
		return $this->belongsTo(Language::class);
	}

	public function courses_enrolments()
	{
		return $this->hasMany(CoursesEnrolment::class);
	}

	public function modules()
	{
		return $this->hasMany(Module::class);
	}

	public function quizzes()
	{
		return $this->hasMany(Quiz::class);
	}

	public function ratings()
	{
		return $this->hasMany(Rating::class);
	}
}
