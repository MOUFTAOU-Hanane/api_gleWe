<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserQuizItem
 * 
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property int $answer_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Answer $answer
 * @property Question $question
 * @property User $user
 *
 * @package App\Models
 */
class UserQuizItem extends Model
{
	protected $table = 'user_quiz_items';

	protected $casts = [
		'user_id' => 'int',
		'question_id' => 'int',
		'answer_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'question_id',
		'answer_id'
	];

	public function answer()
	{
		return $this->belongsTo(Answer::class);
	}

	public function question()
	{
		return $this->belongsTo(Question::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
