<?php

namespace App\Models;

use App\Http\Helpers\MimeExtensionHelper;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'user_id',
        'file_type',
        'file_name',
        'advert_id',
        'advert_request_id',
        'url',
        'is_nudity',
        'on_recognition'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(static function (self $model) {
            $model->user_id = $model->user_id ?? Auth::user()->id;

            if($model->mime) {
                $model->file_type = MimeExtensionHelper::fromMime($model->mime);
                unset($model->mime);
            }

        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advert()
    {
        return $this->belongsTo(Advert::class);
    }

    public function advertRequest()
    {
        return $this->belongsTo(AdvertRequest::class);
    }

    public static function insertMany($documents) : bool {
        array_walk($documents, static function(&$document){
            $document['created_at'] = now();
            $document['updated_at'] = now();
        });

        $table =  $table = with(new static())->getTable();

        return DB::table($table)->insert($documents);
    }

}
