<?php

namespace App\Http\Controllers\Backend\Client\Voucher;

use App\Http\Controllers\Controller;
use App\Services\Client\Voucher\VoucherService;
use App\Services\Setting\SettingService;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Options;
use Illuminate\Http\Request;
use PDF;

class VoucherBatchController extends Controller
{
    /**
     * @var VoucherService
     * @var settingService
     */
    protected $voucherService;
    protected $settingService;

    /**
     * Create a new VoucherBatchController instance.
     * Middleware 'checkPermissions' is applied here to ensure only authorized users can access certain methods.
     * @param  VoucherService  $voucherService
     * @param  SettingService  $settingService
     * @return void
     */
    public function __construct(VoucherService $voucherService, SettingService $settingService)
    {
        $this->voucherService = $voucherService;
        $this->settingService = $settingService;
        // Apply the 'checkPermissions' middleware to this controller with 'voucher-batches' as the required permission
        $this->middleware('checkPermissions:list_voucher_batches,create_voucher_batch,delete_voucher_batch,delete_voucher_batches')->only('index');
    }

    /**
     * Display the list of list voucher-batches.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     * This method retrieves permissions from the request's attributes,
     * set by 'checkPermissions' middleware, and returns a view with these permissions.
     */
    public function index(Request $request)
    {
        // Retrieve the permissions from the request's attributes which were set in the 'checkPermissions' middleware
        $permissions = $request->attributes->get('permissions');
        // Return the view with the permissions.
        return view('backend.clients.vouchers.list-voucher-bathes', compact('permissions'));
    }

    /**
     * Show the datatable for detail a voucher batch.
     * @param  int  $voucherBatchId
     */
    public function show($voucherBatchId)
    {
        // Return the view with the permissions and dataVouchers.
        return view('backend.clients.vouchers.voucher-batch-detail', compact('voucherBatchId'));
    }

    /**
     * Print vouchers data to PDF format.
     * @param int $voucherBatchId The ID of the voucher batch.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function print($voucherBatchId)
    {
        $vouchers = $this->getVouchers($voucherBatchId);
        $timeLimit = $this->getTimeLimit($voucherBatchId);
        $invoice = $this->getInvoiceData();
        $voucherType = $this->getVoucherType($voucherBatchId);
        $logo = $this->getLogo();

        return view('backend.clients.vouchers.print-vouchers', compact('vouchers', 'timeLimit', 'invoice', 'voucherType', 'logo'));

        // TODO: PRINT TO PDF STILL BUG IN CSS NOT WORKING AND FIXME:
        // $pdf = PDF::loadView('backend.clients.vouchers.print-vouchers', [
        //     'vouchers' => $vouchers,
        //     'timeLimit' => $timeLimit,
        //     'invoice' => $invoice,
        //     'voucherType' => $voucherType,
        //     'logo' => $logo
        // ]);
        // return $pdf->stream('vouchers-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Fetches vouchers data by batch ID.
     * @param int $voucherBatchId The ID of the voucher batch.
     * @return mixed The fetched vouchers data.
     */
    private function getVouchers($voucherBatchId)
    {
        return $this->voucherService->getVouchersByBatchId($voucherBatchId);
    }

    /**
     * Fetches and formats time limit of a service.
     * @param int $voucherBatchId The ID of the voucher batch.
     * @return string The formatted time limit.
     */
    private function getTimeLimit($voucherBatchId)
    {
        $voucherBatch = $this->voucherService->getVoucherBatchIdWithService($voucherBatchId);
        return $this->voucherService->formatTimeDisplay($voucherBatch->service->time_limit, $voucherBatch->service->unit_time);
    }

    /**
     * Prepares the invoice data from settings.
     * @return array The prepared invoice data.
     */
    private function getInvoiceData()
    {
        $howToUse = $this->settingService->getSetting('how_to_use_voucher', null);
        $howToUseArray = explode(',', $howToUse);
        return array_map(function ($item) {
            return ['name' => $item];
        }, $howToUseArray);
    }

    /**
     * Fetches the voucher type by batch ID.
     * @param int $voucherBatchId The ID of the voucher batch.
     * @return mixed The fetched voucher type.
     */
    private function getVoucherType($voucherBatchId)
    {
        $voucherBatch = $this->voucherService->getVoucherBatchIdWithService($voucherBatchId);
        return $voucherBatch->type;
    }

    /**
     * Fetches the logo from settings.
     * @return mixed The fetched logo.
     */
    private function getLogo()
    {
        return $this->settingService->getSetting('voucher_logo_filename', null);
    }

}
