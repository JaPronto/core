<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\CreateOrganizationRequest;
use App\Http\Requests\Organization\DeleteOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Requests\Organization\ViewOrganizationRequest;
use App\Http\Resources\OrganizationResource;
use App\Organization;
use App\Repositories\OrganizationRepository;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    protected $organizationRepository;

    public function __construct(OrganizationRepository $organizationRepository)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ViewOrganizationRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ViewOrganizationRequest $request)
    {
        return OrganizationResource::collection($this->organizationRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOrganizationRequest $request
     * @return OrganizationResource
     */
    public function store(CreateOrganizationRequest $request)
    {
        return new OrganizationResource($this->organizationRepository->create($request->only([
            'name',
            'founded_at',
            'country_id',
            'description',
            'image'
        ])));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organization $organization
     * @return OrganizationResource
     */
    public function show(Organization $organization)
    {
        return new OrganizationResource($organization);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Organization $organization
     * @return OrganizationResource
     */
    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        return new OrganizationResource($this->organizationRepository->updateByModel($organization, $request->only([
            'name',
            'founded_at',
            'country_id',
            'description',
            'image'
        ])));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization $organization
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Organization $organization, DeleteOrganizationRequest $request)
    {
        if ($this->organizationRepository->deleteByModel($organization)) return response('', 200);

        abort(500);
    }
}
