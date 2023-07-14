<?php

namespace App\Http\Controllers;

use App\Http\Services\SiteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SitesController extends Controller
{
    /**
     * @var SiteService
     */
    protected SiteService $siteService;

    /**
     * @param SiteService $siteService instance of SiteService
     */
    public function __construct(SiteService $siteService)
    {
       $this->siteService = $siteService;
    }

    /**
     * Get's the list of sites which also displays its corresponding total amount and usage.
     */
    public function index()
    {
       return view(
            'sites', 
            ['sites' => $this->siteService->listSitesWithTotalAmountAndUsage(),]
        );
    }

    /**
     * Get the specific site by id with an added field called yearly_average_amount.
     * 
     * @param string $id Id of the site
     */
    public function detailView(string $id)
    {
        // Validate the id
        $validator = $this->validateId($id);
    
        if ($validator->fails()) {
            return view('not-found');
        }

        return view('site-detail', ['details' => $this->siteService->findByIdWithYearlyAverageAmount($id)]);
    }

    /**
     * This method just get's the speicific site and it's corresponding bills.
     * 
     * @param string $id Id of the site
     * 
     * @return JsonResponse
     */
    public function findByIdWithBills(string $id): JsonResponse
    {
        // Validate the id
        $validator = $this->validateId($id);
    
        if ($validator->fails()) {
            return response()->json(
                ['error' => 'Site ID is invalid!'],
                 400
            );
        }

        return response()->json(
            $this->siteService->findByIdWithBillsForGraph($id)
        );
    }

    /**
     * Validate the site id parameter.
     * 
     * @param string $id
     * 
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateId(string $id)
    {
        // The id is validated and it should be required, should be string with only 10 chars that is alphanumeric 
        // and should exist in the sites table.
        return Validator::make(
            ['id' => $id],
            [
                'id' => [
                    'required',
                    'string',
                    'size:10',
                    'regex:/^[A-Za-z0-9]+$/',
                    'exists:sites,id',
                ],
            ]
        );
    }
}
