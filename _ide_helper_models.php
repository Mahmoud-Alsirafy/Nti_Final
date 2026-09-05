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
 * @property int $pet_id
 * @property int $owner_id
 * @property string|null $status
 * @property int|null $adopter_id
 * @property string|null $why
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $adopter
 * @property-read \App\Models\User $owner
 * @property-read \App\Models\Pet_info $pet
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption whereAdopterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Adoption whereWhy($value)
 */
	class Adoption extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $filename
 * @property int $imageable_id
 * @property string $imageable_type
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
 * @property int $id
 * @property int $userId
 * @property string $clinicName
 * @property string $clinicAddress
 * @property string $clinicNumber
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Images> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\User $info
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data whereClinicAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data whereClinicNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personal_data whereUserId($value)
 */
	class Personal_data extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $ownerId
 * @property string $name
 * @property string $Personality
 * @property string $gender
 * @property string $whight
 * @property string $type
 * @property string $status
 * @property string $categore
 * @property string $description
 * @property int $age
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Images> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereCategore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info wherePersonality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet_info whereWhight($value)
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
 * @property string $phone
 * @property string $type
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Images> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Personal_data|null $personalData
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pet_info> $pits
 * @property-read int|null $pits_count
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

