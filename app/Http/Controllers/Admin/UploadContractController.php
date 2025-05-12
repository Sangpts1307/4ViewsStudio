<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class UploadContractController extends Controller
{

    public function index(GoogleDriveService $googleDriveService)
    {
        $folderPath = public_path('contract/');
        $files = File::files($folderPath); // dùng File facade của Laravel

        if (empty($files)) {
            return redirect()->back()->with('error', 'Không tìm thấy file nào để upload.');
        }

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $fileName = $file->getFilename();

            $result = $googleDriveService->synchronize($filePath, $fileName);

            if ($result) {
                // ✅ Upload thành công thì xóa file
                File::delete($filePath);
            } else {
                Log::error("Upload thất bại cho file: $fileName");
            }
        }

        return redirect()->back()->with('success', 'Đã upload tất cả file PDF lên Google Drive thành công!');
    }
}
