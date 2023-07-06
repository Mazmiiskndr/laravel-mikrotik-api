<?php

namespace App\Exports;

use App\Services\Client\UsersData\UsersDataService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersDataExport implements FromCollection, WithHeadings, WithStyles
{
    protected $usersDataService;
    protected $totalRowNumber;

    /**
     * ListOnlineUsersExport constructor.
     * @param UsersDataService $usersDataService
     */
    public function __construct(UsersDataService $usersDataService)
    {
        $this->usersDataService = $usersDataService;
    }

    /**
     * Get all the active sessions.
     * @return mixed
     */
    public function collection()
    {
        // Retrieve the data from the report service
        $data = $this->usersDataService->getUsersData(null, ['id', 'date', 'name', 'email', 'room_number'])['data'];

        // Transform the data to match the headings
        $mappedData = $data->map(function ($row, $key) {
            return [
                'No' => $key + 1,
                'Guest Name' => $row['name'] ?? '',
                'Email' => $row['email'] ?? '',
                'Room Number' => $row['room_number'] ?? '',
                'Input Date' => date('Y-F-d', strtotime($row['date'])) ?? '',
            ];
        });

        $totalUsers = $mappedData->count();

        $mappedData->push([
            'No' => '',
            'Guest Name' => '',
            'Email' => '',
            'Room Number' => 'TOTAL',
            'Input Date' => $totalUsers,
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
            'Guest Name',
            'Email',
            'Room Number',
            'Input Date'
        ];
    }

    /**
     * Set the styles for the excel sheet.
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Set the fill color to yellow for the header
        $sheet->getStyle('A1:E1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        // Center the text for the header
        $sheet->getStyle('A1:E1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Make the text bold for the header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

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
        $sheet->getStyle('A1:E' . $endRow)->applyFromArray($styleArray);

        // Set all cells alignment to left
        $sheet->getStyle('A1:E' . $endRow)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Set column widths
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set the alignment to right for the total
        if (isset($this->totalRowNumber)) {
            $sheet->getStyle('D' . $this->totalRowNumber + 1 . ':E' . $this->totalRowNumber + 1)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Make the text bold for the total
            $sheet->getStyle('D' . $this->totalRowNumber + 1 . ':E' . $this->totalRowNumber + 1)->getFont()->setBold(true);
        }
    }
}
