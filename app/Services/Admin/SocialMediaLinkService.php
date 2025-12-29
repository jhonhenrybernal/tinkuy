<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SocialMediaLink\SocialMediaLinkRepositoryInterface;

class SocialMediaLinkService
{
    protected $socialMediaLinkRepository;

    public function __construct(SocialMediaLinkRepositoryInterface $socialMediaLinkRepository)
    {
        $this->socialMediaLinkRepository = $socialMediaLinkRepository;
    }

    public function getAllSocialMediaLinks()
    {
        return $this->socialMediaLinkRepository->all();
    }

    public function createSocialMediaLink($data)
    {
        $socialMediaLink = $this->socialMediaLinkRepository->create([
            'type' => $data['type'],
            'platform' => $data['platform'],
            'link' => $data['link'],
        ]);

        foreach ($data['languages'] as $languageCode => $translationData) {
            $this->socialMediaLinkRepository->storeTranslation($socialMediaLink->id, $languageCode, $translationData['name']);
        }

        return $socialMediaLink;
    }

    public function updateSocialMediaLink($id, $data)
    {
        $socialMediaLink = $this->socialMediaLinkRepository->update($id, [
            'type' => $data['type'],
            'platform' => $data['platform'],
            'link' => $data['link'],
        ]);

        foreach ($data['languages'] as $languageCode => $translationData) {
            $this->socialMediaLinkRepository->updateTranslation($socialMediaLink->id, $languageCode, $translationData['name']);
        }

        return $socialMediaLink;
    }

    public function deleteSocialMediaLink($id)
    {
        $this->socialMediaLinkRepository->delete($id);
    }
}
