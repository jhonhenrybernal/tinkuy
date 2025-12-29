<?php

namespace App\Repositories\Admin\SocialMediaLink;

use App\Models\SocialMediaLink;
use App\Models\SocialMediaLinkTranslation;

class SocialMediaLinkRepository implements SocialMediaLinkRepositoryInterface
{
    public function all()
    {
        return SocialMediaLink::all();
    }

    public function create(array $data)
    {
        return SocialMediaLink::create($data);
    }

    public function find($id)
    {
        return SocialMediaLink::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $socialMediaLink = $this->find($id);
        $socialMediaLink->update($data);

        return $socialMediaLink;
    }

    public function delete($id)
    {
        $socialMediaLink = $this->find($id);
        $socialMediaLink->translations()->delete();
        $socialMediaLink->delete();
    }

    public function getTranslations($socialMediaLinkId)
    {
        return SocialMediaLinkTranslation::where('social_media_link_id', $socialMediaLinkId)->get();
    }

    public function storeTranslation($socialMediaLinkId, $languageCode, $name)
    {
        return SocialMediaLinkTranslation::create([
            'social_media_link_id' => $socialMediaLinkId,
            'language_code' => $languageCode,
            'name' => $name,
        ]);
    }

    public function updateTranslation($socialMediaLinkId, $languageCode, $name)
    {
        $translation = SocialMediaLinkTranslation::where('social_media_link_id', $socialMediaLinkId)
            ->where('language_code', $languageCode)
            ->first();

        if ($translation) {
            $translation->update(['name' => $name]);
        } else {
            $this->storeTranslation($socialMediaLinkId, $languageCode, $name);
        }
    }
}
