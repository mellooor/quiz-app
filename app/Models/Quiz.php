<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    /**
     *  Cast the topic_id attribute to the integer data type so that it's converted from a string
     *  after form submission.
     **/
    protected $casts = [
        'topic_id' => 'integer',
    ];

    /**
     * Retrieve the author of the quiz.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'id');
    }

    /**
     * Retrieve the topic of the quiz, if there is one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topic()
    {
        return $this->belongsTo('App\Models\QuizTopic', 'topic_id');
    }
}
