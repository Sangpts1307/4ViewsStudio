<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Log;

class GoogleDriveService
{
    const FOLDER_ID = '14Cg4-oFQprbqeag9ptKF8uT82MXZlS9M';
    private $client;
    private $driveService;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('credential.json'));
        $this->client->addScope(Drive::DRIVE_FILE);

        // Khởi tạo Drive service 1 lần
        $this->driveService = new Drive($this->client);
    }

    public function synchronize($filePath, $fileName)
    {
        try {
            // 🔍 1. Tìm file trùng tên trong folder
            $query = sprintf(
                "name='%s' and '%s' in parents and trashed = false",
                addslashes($fileName),
                self::FOLDER_ID
            );

            $files = $this->driveService->files->listFiles([
                'q' => $query,
                'fields' => 'files(id, name)',
            ]);

            // 🗑️ 2. Nếu tồn tại -> xóa
            foreach ($files->getFiles() as $existingFile) {
                $this->driveService->files->delete($existingFile->getId());
                Log::info("Đã xóa file cũ trên Drive: " . $existingFile->getName());
            }

            // 📤 3. Tạo metadata mới và upload lại
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [self::FOLDER_ID]
            ]);

            $content = file_get_contents($filePath);

            $uploadedFile = $this->driveService->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => mime_content_type($filePath),
                'uploadType' => 'multipart'
            ]);

            return $uploadedFile->id;
        } catch (\Exception $e) {
            Log::error("Google Drive Sync Error: " . $e->getMessage());
            return false;
        }
    }
}
