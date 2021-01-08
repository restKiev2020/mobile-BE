<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ConfirmationCode
 *
 * @property int $id
 * @property int $code
 * @property string $exp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode expired()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode notExpired()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode whereExp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ConfirmationCode whereUpdatedAt($value)
 */
	class ConfirmationCode extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Advert
 *
 * @property int $id
 * @property int $rooms
 * @property int $floor
 * @property int $storeys
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $street
 * @property string $building
 * @property string $city
 * @property string $district
 * @property string $microdistrict
 * @property float $total_area
 * @property float $living_area
 * @property float $kitchen_area
 * @property int $has_repair
 * @property string $construction_type
 * @property string $wall_material
 * @property int $construction_year
 * @property string $building_type
 * @property string $description
 * @property string $title
 * @property int|null $main_image_id
 * @property float|null $price_usd
 * @property float|null $price_uah
 * @property float|null $price_per_ms_usd
 * @property float|null $price_per_ms_uah
 * @property string|null $apartment_number
 * @property string|null $entrance
 * @property string|null $notes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documentsIds
 * @property-read int|null $documents_ids_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favourites
 * @property-read int|null $favourites_count
 * @property-read \App\Models\Document|null $mainImage
 * @property-read \App\Models\Document|null $mainImageId
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereApartmentNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereBuildingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereConstructionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereConstructionYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereEntrance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereFloor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereHasRepair($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereKitchenArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereLivingArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereMainImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereMicrodistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert wherePricePerMsUah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert wherePricePerMsUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert wherePriceUah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert wherePriceUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereStoreys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereTotalArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advert whereWallMaterial($value)
 */
	class Advert extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 * @property string|null $verified_at
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documentsIds
 * @property-read int|null $documents_ids_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Advert[] $favourites
 * @property-read int|null $favourites_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Advert[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVerifiedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $advert_id
 * @property mixed|null $data
 * @property string $file_type
 * @property string|null $file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Advert|null $advert
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document whereUserId($value)
 */
	class Document extends \Eloquent {}
}

