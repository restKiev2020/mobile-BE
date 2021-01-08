<?php

namespace App\Models;

use App\Elastic\AdvertRequest\AdvertRequestIndexConfigurator;
use App\Elastic\AdvertRequest\AdvertRequestSearchRule;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use ScoutElastic\Searchable;

/**
 * Class AdvertRequest
 * @property int id
 * @property int user_id
 * @package App\Models
 */
class AdvertRequest extends Model
{
    use Searchable;

    protected $indexConfigurator = AdvertRequestIndexConfigurator::class;

    protected $searchRules = [
        AdvertRequestSearchRule::class
    ];

    protected $casts = [
        'advert_details' => 'array',
        'on_moderation' => 'boolean',
        'moderated' => 'boolean',
        'approval' => 'boolean'
    ];

    protected $mapping = [];

    protected $fillable = [
        'advert_details',
        'user_id'
    ];

    protected $appends = [
        'documents_ids'
    ];

    protected $hidden = [
        'pivot'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mapping = config('elastic-advert-request.mapping', []);
    }

    public function toSearchableArray() : array
    {
        $searchableArray = $this->jsonSerialize();

        $result = [];

        //TODO: remove dirty hack that will sit there until we clean db -_-
        foreach ($searchableArray as $key=>$value) {
            $snakeCaseKey = Str::snake($key);
            $result[$snakeCaseKey] = $value;
        }
        //get all the text fields and implode them to have the full text search ability
        $keywords = implode(',', array_filter(array_values(array_diff_key($result, array_flip(['updated_at', 'created_at']))), static function ($item) {
            return $item && !is_numeric($item) && !is_bool($item) && !is_array($item);
        }));

        $result['keywords'] = $keywords;

        return $result;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getDocumentsIdsAttribute()
    {
        return $this->documents()->select(['id', 'url', 'is_nudity', 'on_recognition'])->get();
    }

    public function adverts()
    {
        return $this->belongsToMany(Advert::class, 'advert_request_advert', 'advert_request_id', 'advert_id')->withTimestamps();
    }

    public function jsonSerialize($options = 0) : array
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

    public function shouldBeSearchable(): bool
    {
        return true;
    }
}
