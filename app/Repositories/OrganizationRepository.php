<?php

namespace App\Repositories;


use App\Organization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class OrganizationRepository extends BaseRepository
{
    protected $model = Organization::class;

    public function create(array $data)
    {
        $data['image'] = $this->uploadOrganizationImage($data);

        return parent::create($data);

    }

    public function updateByModel(Model $model, array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->uploadOrganizationImage($data);
        }

        return parent::updateByModel($model, $data);
    }

    /**
     * @param array $data
     * @return string
     */
    public function uploadOrganizationImage(array $data)
    {
        if (!$data['image'] instanceof UploadedFile) abort(422, [
            'errors' => [
                'image' => 'image should be a file'
            ]
        ]);

        return basename(uploadFile($data['image'], 'organizations'));
    }
}