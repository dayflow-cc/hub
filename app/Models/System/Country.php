<?php

namespace App\Models\System;

use App\Models\Traits\TranslatedAttribute;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\System\Country
 *
 * @property int $iso2
 * @property string|null $name_local
 * @property array|null $name_translation
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country onlyTrashed()
 * @method static Builder|Country query()
 * @method static Builder|Country withTrashed()
 * @method static Builder|Country withoutTrashed()
 * @mixin Eloquent
 */
class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    use TranslatedAttribute;

    protected $primaryKey = 'iso2';

    protected $table = 'countries';

    protected $casts = [
        'name_translation' => 'array',
    ];

    public function nameLocalized(): Attribute
    {
        return Attribute::make(
            fn() => $this->getJsonTranslatedValue('name_translation', $this->name_local)
        );
    }
}
