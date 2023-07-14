<?php

namespace App\Http\Repositories;

use App\Models\Site;
use Illuminate\Pagination\LengthAwarePaginator;

class SiteRepository
{
    /**
     * Configuration for the pagination
     * 
     * @var int
     */
    const PER_PAGE = 2;

    /**
     * @var Site
     */
    protected Site $site;

    /**
     * @param Site $site Site instance
     */
    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * This method will get the site information by site id.
     * The method does this:
     * Since we have a one to many relationship (site has many bill) then we can eager load the bill.
     * The selectRaw queries the bills table and using a SUM to aggregate the amount of each site per year.
     * Then in the map what we do is that we iterates the Site models/columns and then it calculates the avg amount per site by accessing the bills table.
     * 
     * @param string $id Id of the site
     * 
     * @return Site
     */
    public function findByIdWithYearlyAverageAmount(string $id): Site
    {
        /**
         * Raw query for the eloquent code below is this:
         * 
         * SELECT 
         *    s.id, s.name, s.address, AVG(b.total_amounts) AS yearly_average_amount
         * FROM 
         *    sites s
         * LEFT JOIN (
         *    SELECT site_id, YEAR(bill_start_date) AS year, SUM(amount) AS total_amount
         *    FROM bills
         *    GROUP BY site_id, year
         * ) b ON s.id = b.site_id
         * WHERE 
         *     s.id = $id
         * GROUP BY s.id, s.name, s.address;
         */

        return $this->site
            ->with(['bills' => function ($query) {
                $query
                    ->selectRaw('
                        site_id, 
                        YEAR(bill_start_date) AS year, 
                        SUM(amount) AS total_amount
                    ')
                    ->groupBy('site_id', 'year');
            }])
            ->where('id', $id)
            ->get([
                'id', 
                'name', 
                'address'
            ])
            ->map(function ($site) {
                // Calculates the average amount per site per site and uses the avg method to calculate the average of the total_amount.
                $site->yearly_average_amount = $site->bills->avg('total_amount');

                unset($site->bills);

                // Return a Site object with `yearly_average_amount` column/field included.
                return $site;
            })
            ->first();
    }

    /**
     * This method will get the list of sites with their corresponding site_manager/user and get's the latest bill information.
     * Since the site belongs to a user and has one relationship with the latest bill we can do eager loading. Then we just get the lastest
     * bill per site via bill_start_date. The method also supports pagination for query optimization.
     * 
     * @return LengthAwarePaginator
     */
    public function listSitesWithTotalAmountAndUsage(): LengthAwarePaginator
    {
        /* Sample output:
            {
                "current_page": 1,
                "data": [
                    {
                        "id": "AAAAA00000",
                        "name": "Pasig site",
                        "address": "San Isidro, Makati City",
                        "site_manager_id": 1,
                        "created_at": "2023-07-13T12:00:58.000000Z",
                        "updated_at": null,
                        "bill": {
                            "id": 22,
                            "site_id": "AAAAA00000",
                            "bill_start_date": "2023-06-01",
                            "bill_end_date": "2023-06-30",
                            "electricity_usage": 1500,
                            "amount": "150.00"
                        },
                        "user": {
                            "id": 1,
                            "name": "Michael Jordan",
                            "created_at": "2023-07-13T12:00:55.000000Z",
                            "updated_at": null
                        }
                    }
                ],
                "first_page_url": "http://localhost:8000/api/sites?page=1",
                "from": 1,
                "last_page": 3,
                "last_page_url": "http://localhost:8000/api/sites?page=3",
                "links": [
                    {
                        "url": null,
                        "label": "&laquo; Previous",
                        "active": false
                    },
                    {
                        "url": "http://localhost:8000/api/sites?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": "http://localhost:8000/api/sites?page=2",
                        "label": "2",
                        "active": false
                    },
                    {
                        "url": "http://localhost:8000/api/sites?page=3",
                        "label": "3",
                        "active": false
                    },
                    {
                        "url": "http://localhost:8000/api/sites?page=2",
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "next_page_url": "http://localhost:8000/api/sites?page=2",
                "path": "http://localhost:8000/api/sites",
                "per_page": 1,
                "prev_page_url": null,
                "to": 1,
                "total": 3
            }
        */

        $paginator = $this->site->with(['user', 'latestBill'])
            ->paginate(self::PER_PAGE);

        $paginator
            ->getCollection()
            ->transform(function ($site) { // we just want to rename the key to bill rather than latest bill
                // added a bill key, so we can only retrieve one bill which is logical and store the latestBill there
                $site['bill'] = $site->latestBill;

                // remove the latest_bill_key
                unset($site['latestBill']);

                return $site;
            });

        return $paginator;
    }

    /**
     * This returns a site model with its corresponding bills.
     * Since we have has many relationship with bills it's easy to append them them with Site model.
     * 
     * @param string $id
     * 
     * @return Site
     */
    public function findByIdWithBills(string $id): Site
    {
        /* Sample output:
            {
                "id": "AAAAA00000",
                "name": "Pasig site",
                "address": "San Isidro, Makati City",
                "site_manager_id": 1,
                "created_at": "2023-07-13T12:00:58.000000Z",
                "updated_at": null,
                "bills": [
                    {
                        "id": 1,
                        "customer_account_number": "CAN0000001",
                        "invoice_number": "INV0000001",
                        "site_id": "AAAAA00000",
                        "bill_start_date": "2022-05-01",
                        "bill_end_date": "2022-05-31",
                        "amount": "50.00",
                        "electricity_usage": 500,
                        "created_at": "2023-07-13T12:01:00.000000Z",
                        "updated_at": null
                    },
                    {
                        "id": 2,
                        "customer_account_number": "CAN0000002",
                        "invoice_number": "INV0000002",
                        "site_id": "AAAAA00000",
                        "bill_start_date": "2022-05-01",
                        "bill_end_date": "2022-05-31",
                        "amount": "100.00",
                        "electricity_usage": 1000,
                        "created_at": "2023-07-13T12:01:00.000000Z",
                        "updated_at": null
                    }
                ]
            }
        */

        return $this->site->with('bills')->find($id);
    }
}
