<?php

namespace App\Repositories;


use App\Organization;
use Illuminate\Http\UploadedFile;

class OrganizationRepository extends BaseRepository
{
    protected $model = Organization::class;

    public function create(array $data)
    {
        if (!$data['image'] instanceof UploadedFile) abort(422, [
            'errors' => [
                'image' => 'image should be a file'
            ]
        ]);

        $data['image'] = basename(uploadFile($data['image'], 'organizations'));

        return parent::create($data);

    }
}