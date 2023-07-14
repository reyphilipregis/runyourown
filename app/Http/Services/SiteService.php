<?php

namespace App\Http\Services;

use App\Http\Repositories\SiteRepository;
use App\Models\Site;
use Illuminate\Pagination\LengthAwarePaginator;

class SiteService
{
    /**
     * @var SiteRepository
     */
    protected SiteRepository $siteRepository;
    
    /**
     * @param SiteRepository $siteRepository Site repository instance
     */
    public function __construct(SiteRepository $siteRepository)
    {
        $this->siteRepository = $siteRepository;
    }

    /**
     * This method will get the site information by site id.
     * 
     * @param string $id Id of the site
     * 
     * @return Site
     */
    public function findByIdWithYearlyAverageAmount(string $id): Site
    {
        return $this->siteRepository->findByIdWithYearlyAverageAmount($id);
    }

    /**
     * This method gets all the sites with the corresponder site manager/user and get's the latest bill.
     * 
     * @return LengthAwarePaginator
     */
    public function listSitesWithTotalAmountAndUsage(): LengthAwarePaginator
    {
        return $this->siteRepository->listSitesWithTotalAmountAndUsage();
    }

    /**
     * This method gets a specific site with their corresponding bills and transform the data for graph purposes.
     * 
     * @param int $id This is the site id
     * 
     * @return array
     */
    public function findByIdWithBillsForGraph(string $id): array
    {
        return $this->transformSiteDataForHighcharts(
            $this->siteRepository->findByIdWithBills($id)->toArray()
        );
    }

    /**
     * Transform the Site model data into the format required by Highcharts.
     *
     * @param array $siteData
     *
     * @return array
     */
    private function transformSiteDataForHighcharts(array $siteData): array
    {
        $billData = [];

        foreach ($siteData['bills'] as $bill) {
            $billData[] = ['Bill-' . $bill['id'], $bill['amount']];
        }

        return $billData;
    }
}

