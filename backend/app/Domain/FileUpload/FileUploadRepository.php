<?php

namespace App\Domain\FileUpload;

use App\Models\FileUpload;
use Exception;
use Faker\Provider\File;
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
        return FileUpload::whereUserId($userId)->orderBy(FileUpload::ID, 'DESC')->get();
    }

    /**
     * @param FileUpload $fileUpload
     * @return bool
     * @throws Exception
     */
    public function deleteImage(FileUpload $fileUpload): bool
    {
        return $fileUpload->delete();
    }

    /**
     * @param int $fileUploadId
     * @return FileUpload|null
     */
    public function findFileUploadById(int $fileUploadId): ?FileUpload
    {
        return FileUpload::find($fileUploadId);
    }
}
