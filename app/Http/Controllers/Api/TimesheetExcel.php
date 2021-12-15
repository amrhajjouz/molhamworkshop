<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TimesheetUsersChecks;
use App\Models\DaysTimesheet;
use App\Models\MonthsTimesheet;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TimesheetExcel extends Controller
{
    public function __construct () {}

    public function timesheetExcel($id){
        try{
            $user = User::findOrFail($id);
            $checks = TimesheetUsersChecks::orderBy('created_at')->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->where('user_id', $user['id'])->get();
            $monthTimesheet = MonthsTimesheet::where('user_id', $user['id'])->whereYear('month', date('Y'))->whereMonth('month', date('m'))->firstOrFail();
            $helper = new Sample();
            if ($helper->isCli()) {
                $helper->log('This example should only be run from a Web Browser' . PHP_EOL);

                return;
            }
            // Create new Spreadsheet object
            $spreadsheet = new Spreadsheet();

            // Set document properties
            $spreadsheet->getProperties()->setCreator('Molham Team')
                ->setLastModifiedBy('Molham Team')
                ->setTitle($user['name'] . ' Timesheet')
                ->setSubject($user['name'] . ' Timesheet');

            $r = 1;

            // Add some data
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $r, 'Name: ')
                ->setCellValue('B' . $r, $user['name'])
                ->setCellValue('D' . $r, 'Month\'s Total Hours: ')
                ->setCellValue('E' . $r, $monthTimesheet['working_hours'])
                ->setCellValue('G' . $r, 'Total Overtime: ')
                ->setCellValue('H' . $r, $monthTimesheet['overtime_hours']);

            ++$r;

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $r, 'Check Type')
                ->setCellValue('B' . $r, 'Date');

            ++$r;

            foreach($checks as $check){
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $r, $check['type'] == 'in' ? 'In' : 'Out')
                    ->setCellValue('B' . $r, date('d/m/Y H:i A', strtotime($check['created_at'])));
                ++$r;
            }

            foreach (range('A', 'H') as $letra) {
                $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
            }

            // Miscellaneous glyphs, UTF-8
            $spreadsheet->setActiveSheetIndex(0);

            // Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Timesheet');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);

            $fileName = $user['name'] . ' - ' . date('M') . ' Timesheet';

            // Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
        } catch(\Exception $e){
            //
        }
    }
}

