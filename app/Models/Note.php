<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * Class Note
 *
 * @package App\Models
 * @property int $id
 * @property string $noteable_type
 * @property int $noteable_id
 * @property string $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|\Eloquent $noteable
 * @method static Builder|Note newModelQuery()
 * @method static Builder|Note newQuery()
 * @method static Builder|Note query()
 * @method static Builder|Note whereBody($value)
 * @method static Builder|Note whereCreatedAt($value)
 * @method static Builder|Note whereId($value)
 * @method static Builder|Note whereNoteableId($value)
 * @method static Builder|Note whereNoteableType($value)
 * @method static Builder|Note whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Note extends Model
{
    use HasFactory;

    /**
     * Get the parent noteable model (account or contact).
     */

    public function noteable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function contact()
    {
        return $this->morphTo(Contact::class, 'noteable');
    }

}
