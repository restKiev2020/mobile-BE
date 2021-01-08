<?php

namespace App\Models;

use App\Elastic\Advert\AdvertIndexConfigurator;
use App\Elastic\Advert\AdvertSearchRule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

/**
 * Class Advert
 * @package App\Models
 * @property User user
 */
class Advert extends Model
{
    use Searchable;

    protected $indexConfigurator = AdvertIndexConfigurator::class;

    protected $searchRules = [
        AdvertSearchRule::class
    ];

    protected $mapping;

    protected $casts = [
        'advert_details' => 'array',
        'has_repair' => 'boolean',
        'on_moderation' => 'boolean',
        'moderated' => 'boolean',
        'approval' => 'boolean'
    ];

    public const OWNER_FIELDS = [
        'apartment_number',
        'entrance',
        'notes'
    ];

    protected $fillable = [
        'price_usd',
        'price_uah',
        'price_per_ms_usd',
        'price_per_ms_uah',
        'user_id',
        'street',
        'building',
        'city',
        'district',
        'microdistrict',
        'total_area',
        'has_repair',
        'title',
        'description',
        'notes',
        'property_type',
        'advert_details',
        'type',
        'region',
    ];

    protected $appends = [
        /*'documents_ids'*/
    ];

    protected $hidden = [
        'pivot'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->mapping = config('elastic-advert.mapping', []);
    }

    public function toSearchableArray() : array
    {
        $searchableArray = $this->jsonSerialize();

        //get all the text fields and implode them to have the full text search ability
        $keywords = implode(',', array_filter(array_values(array_diff_key($searchableArray, array_flip(['updated_at', 'created_at']))), static function ($item) {
            return $item && !is_numeric($item) && !is_bool($item) && !is_array($item);
        }));

        $searchableArray['keywords'] = $keywords;

        return $searchableArray;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getUserPhoneAttribute()
    {
        return $this->user->phone_number;
    }

    public function getUserAvatarAttribute()
    {
        return $this->user->avatar;
    }

    public function getDocumentsIdsAttribute()
    {
        return $this->documents()->select(['id', 'url', 'is_nudity', 'on_recognition'])->get();
    }

    public function mainImage()
    {
        return $this->hasOne(Document::class, 'id', 'main_image_id');
    }

    public function mainImageId()
    {
        return $this->hasOne(Document::class, 'id', 'main_image_id')
            ->select(['documents.id', 'documents.advert_id' ]);
    }

    public function favourites()
    {
        return $this->belongsToMany(User::class, 'user_advert_favourites', 'advert_id', 'user_id')->withTimestamps();
    }

    public function appointments()
    {
        return $this->belongsToMany(User::class, 'appointments', 'advert_id', 'user_id')->withTimestamps();
    }

    public function requests()
    {
        return $this->belongsToMany(AdvertRequest::class, 'advert_request_advert', 'advert_id', 'advert_request_id')->withTimestamps();
    }

    public function getRequestsIdsAttribute()
    {
        return $this->requests()->pluck('advert_requests.id');
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function jsonSerialize($options = 0): array
    {
        $base = array_diff_key($this->toArray(), array_flip(['advert_details']));

        $details = $this->getAttribute('advert_details');

        return array_merge($base, $details ?? []);
    }

    /**
     * @param array $elasticQuery
     * @param string|null $queryString
     * @param $perPage
     * @return LengthAwarePaginator
     */
    public static function performSearch(array $elasticQuery, ?string $queryString, $perPage)
    {
        $query = self::search(!$queryString || $queryString === '' ? '*' : $queryString);

        foreach ($elasticQuery['terms'] as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
                continue;
            }
            $query->where($field, $value);
        }

        foreach ($elasticQuery['match'] as $field => $value) {
            $query->whereMatch($field, $value);
        }

        foreach ($elasticQuery['range'] as $field => $values ) {
            if(count($values) === 2) {
                $query->whereBetween($field, [$values['from'], $values['to']]);
            }
            else {
                $value = array_values($values);
                switch (array_keys($values)[0]) {
                    case 'from':
                        $query->where($field, '>', $value[0]);
                        break;
                    case 'to':
                        $query->where($field, '<', $value[0]);
                        break;
                }
            }
        }

        return $query->orderBy('created_at', 'DESC')->take(100)->paginate($perPage);
    }
}

