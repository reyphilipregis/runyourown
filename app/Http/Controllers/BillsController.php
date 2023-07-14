<?php

namespace App\Http\Controllers;

use App\Http\Services\BillService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class BillsController extends Controller
{
    /**
     * @var BillService
     */
    protected BillService $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    /**
     * This method will show the bills index page.
     */
    public function index()
    {
        return view('bills');
    }

    /**
     * Get list of invoice numbers by month and year.
     * This method will only accept month that is between 1-12
     * This method will only accept year with four digits ex 2023
     *
     * @param int $month The month (1-12).
     * @param int $year The year.
     *
     * @return JsonResponse list of invoice numbers only
     */
    public function getListOfInvoiceNumbersByMonthAndYear(int $month, int $year): JsonResponse
    {
        // Validate the route parameters
        $validator = Validator::make(
            [
                'month' => $month, 
                'year' => $year
            ], 
            [
                'month' => ['required', 'integer', 'between:1,12'],
                'year' => ['required', 'integer', 'digits:4'],
            ]
        );

        // Check if validation fails
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return response()->json(['errors' => $errors], 400);
        }

        return response()->json(
            $this->billService->getBillInvoiceNumbersByMonthAndYear($month, $year)
        );
    }
}
