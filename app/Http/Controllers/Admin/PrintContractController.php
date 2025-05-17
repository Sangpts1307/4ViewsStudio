<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\Contract;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrintContractController extends Controller
{
    public function index(Request $request, $contractId)
    {
        $contract = Contract::with('appointment')
        
        ->where('id', $contractId)->first();

        $work_day = Carbon::parse($contract->appointment->work_day)->format('d-m-Y');
        $user = User::find($contract->appointment->user_id);
        $concept = Concept::find($contract->appointment->concept_id);

        $pdf = Pdf::loadView('admin.print-contract', compact('contract', 'user', 'concept', 'work_day'));

        // Tạo tên file PDF
        $fileName = $work_day . '-' . $user->name . '-' . $concept->name . '.pdf';

        // Đường dẫn thư mục lưu file
        $folderPath = public_path('contract/');

        // Tạo thư mục nếu chưa có
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        // Đường dẫn đầy đủ đến file PDF
        $filePath = $folderPath . '/' . $fileName;

        // Nếu file đã tồn tại thì xóa
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Lưu file vào thư mục
        $pdf->save($filePath);

        // Trả file PDF về trình duyệt (nếu muốn mở luôn)
       return response()->file($filePath);



    }
}
