<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * 
 * @property int $id
 * @property string $text
 * @property int $quiz_id
 * @property string|null $resource
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Quiz $quiz
 * @property Collection|Answer[] $answers
 * @property Collection|UserQuizItem[] $user_quiz_items
 *
 * @package App\Models
 */
class Question extends Model
{
	protected $table = 'questions';

	protected $casts = [
		'quiz_id' => 'int'
	];

	protected $fillable = [
		'text',
		'quiz_id',
		'resource'
	];

	public function quiz()
	{
		return $this->belongsTo(Quiz::class);
	}

	public function answers()
	{
		return $this->hasMany(Answer::class);
	}

	public function user_quiz_items()
	{
		return $this->hasMany(UserQuizItem::class);
	}
}
