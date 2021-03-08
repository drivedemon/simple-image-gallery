<?php

namespace App\Domain\FileUpload;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface FileUploadRepositoryInterface
 * @package App\Domain\FileUpload
 */
interface FileUploadRepositoryInterface
{
    /**
     * @param array $payload
     * @return FileUpload
     */
    public function createFileUpload(array $payload): FileUpload;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getFileUploadByUserId(int $userId): Collection;

    /**
     * @param fileUpload $fileUpload
     * @return bool
     */
    public function deleteImage(fileUpload $fileUpload): bool;

    /**
     * @param int $fileUploadId
     * @return FileUpload|null
     */
    public function findFileUploadById(int $fileUploadId): ?FileUpload;
}
