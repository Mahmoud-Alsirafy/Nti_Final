<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $filename
 * @property int $imageableId
 * @property string $imageableType
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Images whereUpdatedAt($value)
 */
	class Images extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Images> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\User|null $info
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data query()
 */
	class Personal_data extends \Eloquent {}
}

namespace App\Models{
/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Images> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info query()
 */
	class Pet_info extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $type
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

