<?php

namespace App\Exports;

use App\Services\Client\Voucher\VoucherService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VoucherBatchDetailExport implements FromCollection, WithHeadings, WithStyles
{
    protected $voucherService;
    protected $voucherBatchId;
    protected $totalRowNumber;

    /**
     * VoucherBatchDetailExport constructor.
     * @param VoucherService $voucherService
     */
    public function __construct(VoucherService $voucherService, $voucherBatchId)
    {
        $this->voucherService = $voucherService;
        $this->voucherBatchId = $voucherBatchId;
    }

    /**
     * Get all the active sessions.
     * @return mixed
     */
    public function collection()
    {
        // Retrieve the data from the report service
        $data = $this->voucherService->getVouchersByBatchId($this->voucherBatchId);

        // Transform the data to match the headings
        $mappedData = $data->map(function ($row, $key) {
            return [
                'No' => $key + 1,
                'S/N' => $row['serial_number'] ?? '',
                'Username' => $row['username'] ?? '',
                'Password' => $row['password'] ?? '',
                'Total Time Used' => $row['first_use'] ?? '-',
                'Valid Until' => $row['valid_until'] ?? '-',
                'Status' => ucwords($row['status']) ?? '',
            ];
        });

        $totalVouchers = $mappedData->count();

        $mappedData->push([
            'No' => '',
            'S/N' => '',
            'Username' => '',
            'Password' => '',
            'Total Time Used' => '',
            'Valid Until' => 'TOTAL',
            'Status' => $totalVouchers,
        ]);

        // Save the row number of the total
        $this->totalRowNumber = $mappedData->count();

        return $mappedData;
    }


    /**
     * Define the headings for the excel sheet.
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'No',
            'S/N',
            'Username',
            'Password',
            'Total Time Used',
            'Valid Until',
            'Status',
        ];
    }

    /**
     * Set the styles for the excel sheet.
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Set the fill color to yellow for the header
        $sheet->getStyle('A1:G1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        // Center the text for the header
        $sheet->getStyle('A1:G1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Make the text bold for the header
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);

        // Add border to the cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        // Get the last row number
        $endRow = $sheet->getHighestRow();

        // Apply the border style to all cells
        $sheet->getStyle('A1:G' . $endRow)->applyFromArray($styleArray);

        // Set column widths
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set the alignment to right for the total
        if (isset($this->totalRowNumber)) {
            $sheet->getStyle('F' . $this->totalRowNumber + 1 . ':G' . $this->totalRowNumber + 1)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Make the text bold for the total
            $sheet->getStyle('F' . $this->totalRowNumber + 1 . ':G' . $this->totalRowNumber + 1)->getFont()->setBold(true);
        }
    }
}
