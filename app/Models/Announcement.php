<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\EventType; 
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Brackets\AdminAuth\Models\AdminUser;

class Announcement extends Model implements HasMedia
{
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use ProcessMediaTrait;

    protected $fillable = [
        'event_type_id',
        'header_img',
        'title',
        'description',
        'url',
        'starts_at',
        'ends_at',
        'model_id'
    ];
    
    
    protected $dates = [
        'starts_at',
        'ends_at',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    public function getAvatarThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('header', 'thumb_150') ?: null;
    }
    
    /* ************************ MEDIA ************************ */

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void {
        $this->addMediaCollection('header')
            ->useDisk('s3')
            ->accepts('image/*')
            ->maxNumberOfFiles(20);
    }

    /**
     * Register media conversions
     *
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }

     /**
     * Auto register thumb overridden
     */
    public function autoRegisterThumb200()
    {
        $this->getMediaCollections()->filter->isImage()->each(function ($mediaCollection) {
            $this->addMediaConversion('thumb_200')
                ->width(200)
                ->height(200)
                ->fit('crop', 200, 200)
                ->optimize()
                ->performOnCollections($mediaCollection->getName())
                ->nonQueued();
        });
    }


    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/announcements/'.$this->getKey());
    }

    /********************** RELATIONSHIPS *************************/

    public function event_types(){ 
        return $this->belongsTo(EventType::class, 'event_type_id');
    }

    public function admin_user() {
        return $this->belongsTo(AdminUser::class, 'model_id');
    }
}
