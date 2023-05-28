<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * 
 * @property int $id
 * @property string $text
 * @property bool $is_valid
 * @property int $question_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Question $question
 * @property Collection|UserQuizItem[] $user_quiz_items
 *
 * @package App\Models
 */
class Answer extends Model
{
	protected $table = 'answers';

	protected $casts = [
		'is_valid' => 'bool',
		'question_id' => 'int'
	];

	protected $fillable = [
		'text',
		'is_valid',
		'question_id'
	];

	public function question()
	{
		return $this->belongsTo(Question::class);
	}

	public function user_quiz_items()
	{
		return $this->hasMany(UserQuizItem::class);
	}
}
