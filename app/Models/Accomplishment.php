<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Accomplishment extends Model implements HasMedia
{
    
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;
    use HasMediaThumbsTrait;
    use ProcessMediaTrait;

    protected $fillable = [
        'gad_plans_id',
        'header',
        'description',
        'admin_users_id',
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    public function getAvatarThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('gallery', 'thumb_150') ?: null;
    }
    
    /* ************************ MEDIA ************************ */

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void {
        $this->addMediaCollection('gallery')
            ->accepts('image/*')
            ->maxNumberOfFiles(20)
            ->canView('media.view')
            ->canUpload('media.upload');
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
        return url('/admin/accomplishments/'.$this->getKey());
    }
}
