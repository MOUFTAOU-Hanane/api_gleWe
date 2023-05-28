<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Course[] $courses
 *
 * @package App\Models
 */
class Language extends Model
{
	protected $table = 'languages';

	protected $fillable = [
		'name'
	];

	public function courses()
	{
		return $this->hasMany(Course::class);
	}
}
