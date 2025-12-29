<?php

namespace App\Services\Admin;

use App\Repositories\Admin\Attribute\AttributeRepositoryInterface;

class AttributeService
{
    protected $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function getAllAttributes()
    {
        return $this->attributeRepository->getAll();
    }

    public function getAttributeById($id)
    {
        return $this->attributeRepository->getById($id);
    }

    public function createAttribute(array $data)
    {
        return $this->attributeRepository->store($data);
    }

    public function updateAttribute($attribute, array $data)
    {
        return $this->attributeRepository->update($attribute, $data);
    }

    public function deleteAttribute($id)
    {
        return $this->attributeRepository->delete($id);
    }
}
