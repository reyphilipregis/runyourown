<?php

namespace App\Http\Repositories;

use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BillRepository
{
    /**
     * @var Bill
     */
    protected Bill $bill;

    /**
     * @param Bill $bill
     */
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }

    /**
     * Get bills by start and end date.
     *
     * @param Carbon $startDate YYYY-mm-dd
     * @param Carbon $endDate YYYY-mm-dd
     *
     * @return Collection Collection of Bills object
     */
    public function getBillsByStartAndEndDate(Carbon $startDate, Carbon $endDate): Collection
    {
        return $this->bill
            ->whereBetween(
                'bill_start_date', 
                [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]
            )
            ->get();
    }
}
