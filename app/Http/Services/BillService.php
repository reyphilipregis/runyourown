<?php

namespace App\Http\Services;

use App\Http\Repositories\BillRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BillService
{
    /**
     * @var BillRepository
     */
    protected BillRepository $billRepository;

    /**
     * BillService constructor.
     *
     * @param BillRepository $billRepository The bill repository instance.
     */
    public function __construct(BillRepository $billRepository)
    {
        $this->billRepository = $billRepository;
    }

    /**
     * Get list of invoice numbers only of bills by month and year.
     * Pluck is used to just get a specific field.
     *
     * @param int $month The month (1-12).
     * @param int $year The year.
     *
     * @return Collection of invoice numbers
     */
    public function getBillInvoiceNumbersByMonthAndYear(int $month, int $year): Collection
    {
        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $endOfMonth = Carbon::createFromDate($year, $month)->endOfMonth();

        return $this->billRepository
            ->getBillsByStartAndEndDate($startOfMonth, $endOfMonth)
            ->pluck('invoice_number');
    }
}
