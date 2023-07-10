<?php

namespace App\Exports;

use App\Services\Client\HotelRoom\HotelRoomService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class HotelRoomExport implements FromCollection, WithHeadings, WithStyles
{
    protected $hotelRoomService;
    protected $totalRowNumber;

    /**
     * ListOnlineUsersExport constructor.
     * @param HotelRoomService $hotelRoomService
     */
    public function __construct(HotelRoomService $hotelRoomService)
    {
        $this->hotelRoomService = $hotelRoomService;
    }

    /**
     * Get all the active sessions.
     * @return mixed
     */
    public function collection()
    {
        // Retrieve the data from the hotel rooms service
        $data = $this->hotelRoomService->getHotelRoomsWithService(null,['*'])['data'];

        // Transform the data to match the headings
        $mappedData = $data->map(function ($row, $key) {
            return [
                'No' => $key + 1,
                'Room Number' => $row['room_number'] ?? '',
                'Name' => $row['name'] ?? '',
                'Password' => $row['password'] ?? '',
                'Service' => $row['service']['service_name'] ?? '',
                'Status' => ucwords($row['status']) ?? '',
            ];
        });

        $totalHotelRooms = $mappedData->count();

        $mappedData->push([
            'No' => '',
            'Room Number' => '',
            'Name' => '',
            'Password' => '',
            'Service' => 'TOTAL',
            'Status' => $totalHotelRooms,
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
            'Room Number',
            'Name',
            'Password',
            'Service',
            'Status'
        ];
    }

    /**
     * Set the styles for the excel sheet.
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Set the fill color to yellow for the header
        $sheet->getStyle('A1:F1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');

        // Center the text for the header
        $sheet->getStyle('A1:F1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Make the text bold for the header
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

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
        $sheet->getStyle('A1:F' . $endRow)->applyFromArray($styleArray);

        // Set column widths
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set the alignment to right for the total
        if (isset($this->totalRowNumber)) {
            $sheet->getStyle('E' . $this->totalRowNumber + 1 . ':F' . $this->totalRowNumber + 1)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Make the text bold for the total
            $sheet->getStyle('E' . $this->totalRowNumber + 1 . ':F' . $this->totalRowNumber + 1)->getFont()->setBold(true);
        }
    }
}
