<?php

namespace App\Domain\FileUpload;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Collection;

/**
 * class FileUploadRepository
 * @package App\Domain\FileUpload
 */
class FileUploadRepository implements FileUploadRepositoryInterface
{
    /**
     * @param array $payload
     * @return FileUpload
     */
    public function createFileUpload(array $payload): FileUpload
    {
        return FileUpload::create($payload);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getFileUploadByUserId(int $userId): Collection
    {
        return FileUpload::whereUserId($userId)->get();
    }
}
