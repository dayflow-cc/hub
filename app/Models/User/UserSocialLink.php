<?php

namespace App\Models\User;

use App\Models\User;
use CodersCantina\Filter\Filterable;
use CodersCantina\Hashids\Hashidable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\User\UserSocialLink
 *
 * @property int $id
 * @property string $external_id
 * @property string $service
 * @property string|null $token
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @method static Builder|UserSocialLink filter(\CodersCantina\Filter\Filter $filter)
 * @method static Builder|UserSocialLink newModelQuery()
 * @method static Builder|UserSocialLink newQuery()
 * @method static Builder|UserSocialLink query()
 * @mixin Eloquent
 */
class UserSocialLink extends Model
{
    use Filterable;
    use HasFactory;
    use Hashidable;

    protected $table = 'user_social_links';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
