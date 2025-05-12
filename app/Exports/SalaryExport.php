<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Salary;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalaryExport implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $month;
    public function __construct($month)
    {
        $this->month = $month;
    }
    public function collection()
    {
        $exportData = [];
        //dữ liệu đầu ra ở đây sẽ phải khớp với headings
        $salaries = DB::table('salaries')
            ->join('users', 'users.id', '=', 'salaries.user_id')
            ->where('salaries.month', $this->month)
            ->get();
        foreach ($salaries as $salary) {
            $salary->txt_status = Salary::CONVERT_PAID_STATUS[$salary->status];
            $finished_shift_tmp = "0";
                if ($salary->finished_shift != 0) {
                    $finished_shift_tmp = $salary->finished_shift;
                }
            $exportData[] = [
                $salary->user_id,
                $salary->name,
                $salary->email,
                $salary->total_shift,
                $finished_shift_tmp,
                $salary->total_salary,

                Salary::CONVERT_PAID_STATUS[$salary->status]

            ];
        }
        return collect($exportData);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nhân viên',
            'Email',
            'Số ca làm',
            'Ca chụp hoàn thành',
            'Lương',
            'Trả lương'
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0000FF']
                ]
            ]
        ];
    }
}
