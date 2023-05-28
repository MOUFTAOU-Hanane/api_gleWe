<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string|null $profil_pic
 * @property string|null $adresse
 * @property string|null $profession
 * @property string|null $school_degree
 * @property string|null $gender
 * @property string $email
 * @property int $role_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $reference
 * @property int $country_id
 * 
 * @property Country $country
 * @property Role $role
 * @property Collection|CoursesEnrolment[] $courses_enrolments
 * @property Collection|Rating[] $ratings
 * @property Collection|UserQuizItem[] $user_quiz_items
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'role_id' => 'int',
		'country_id' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'password',
		'profil_pic',
		'adresse',
		'profession',
		'school_degree',
		'gender',
		'email',
		'role_id',
		'reference',
		'country_id'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function courses_enrolments()
	{
		return $this->hasMany(CoursesEnrolment::class);
	}

	public function ratings()
	{
		return $this->hasMany(Rating::class);
	}

	public function user_quiz_items()
	{
		return $this->hasMany(UserQuizItem::class);
	}
}
