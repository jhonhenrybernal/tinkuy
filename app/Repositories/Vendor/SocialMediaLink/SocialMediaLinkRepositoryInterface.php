<?php

namespace App\Repositories\Vendor\SocialMediaLink;

interface SocialMediaLinkRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find($id);

    public function update($id, array $data);

    public function delete($id);

    public function getTranslations($socialMediaLinkId);

    public function storeTranslation($socialMediaLinkId, $languageCode, $name);

    public function updateTranslation($socialMediaLinkId, $languageCode, $name);
}
