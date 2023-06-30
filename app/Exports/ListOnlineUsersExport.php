<?php

namespace App\Exports;

use App\Services\Report\ReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ListOnlineUsersExport implements FromCollection, WithHeadings, WithStyles
{
    protected $reportService;

    /**
     * ListOnlineUsersExport constructor.
     * @param ReportService $reportService
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Get all the active sessions.
     * @return mixed
     */
    public function collection()
    {
        // Retrieve the data from the report service
        $data = $this->reportService->getAllRadAcct()['activeSessions'];

        // Transform the data to match the headings
        $mappedData = $data->map(function ($row, $key) {
            return [
                'No' => $key + 1,
                'Username' => $row['username'] ?? '',
                'First Use' => $row['firsttime'] ?? '',
                'Session Start' => $row['starttime'] ?? '',
                'Online Time' => $row['oltime'] ?? '',
                'IP Address' => $row['ipaddress'] ?? '',
                'MAC Address' => $row['macaddress'] ?? '',
            ];
        });

        $totalUsers = $mappedData->count();

        $mappedData->push([
            'No' => '',
            'Username' => '',
            'First Use' => '',
            'Session Start' => '',
            'Online Time' => '',
            'IP Address' => 'TOTAL',
            'MAC Address' => $totalUsers,
        ]);


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
            'Username',
            'First Use',
            'Session Start',
            'Online Time',
            'IP Address',
            'MAC Address',
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
        $sheet->getStyle('F' . $endRow)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Make the text bold for the total
        $sheet->getStyle('F' . $endRow . ':G' . $endRow)->getFont()->setBold(true);
    }
}
