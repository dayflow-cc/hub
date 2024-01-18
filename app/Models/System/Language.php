<?php

namespace App\Models\System;

use CodersCantina\Hashids\Hashidable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\System\Language
 *
 * @property int $iso
 * @property string|null $locale
 * @property string $name
 * @property string $name_local
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereNameLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Language withoutTrashed()
 * @mixin \Eloquent
 */
class Language extends Model
{
    use Hashidable;
    use SoftDeletes;

    protected $primaryKey = 'iso';

    protected $table = 'languages';
}
