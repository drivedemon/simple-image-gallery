<?php

namespace App\Domain\FileUpload;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FileUploadService
{
    /**
     * @var FileUploadRepositoryInterface
     */
    private FileUploadRepositoryInterface $repository;
    /**
     * @var int
     */
    private int $allowedFileSize;
    /**
     * @var array
     */
    private array $allowedFileTypes;
    /**
     * @var string
     */
    private string $defaultPath;
    /**
     * @var array
     */
    private array $exceptParams;

    /**
     * FileUploadService constructor.
     * @param FileUploadRepositoryInterface $repository
     */
    public function __construct(FileUploadRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->allowedFileSize = FileUpload::ALLOWED_FILE_SIZE;
        $this->allowedFileTypes = FileUpload::ALLOWED_FILE_TYPE;
        $this->defaultPath = FileUpload::DEFAULT_STORAGE_PATH;
        $this->exceptParams = FileUpload::EXCEPT_PARAMETERS;
    }

    /**
     * @param FileUploadDTO $payload
     * @return FileUpload
     */
    public function createFileUpload(FileUploadDTO $payload): FileUpload
    {
        return $this->repository->createFileUpload(
            Arr::except($payload->toArray(), $this->exceptParams)
        );
    }

    /**
     * @param FileUploadDTO $payload
     * @return FileUploadDTO
     */
    public function uploadFileStorage(FileUploadDTO $payload): FileUploadDTO
    {
        if (!$payload->getValidate()) {
            return $payload;
        }

        $pathFile = Storage::put("{$this->defaultPath}{$payload->getUserId()}", $payload->getFile());
        return $payload->setFilePath(Storage::url($pathFile));
    }

    public function extractDetail(FileUploadDTO $payload): FileUploadDTO
    {
        $payload->setFileExtension($payload->getFile()->extension());
        $payload->setFileName($payload->getFile()->getClientOriginalName());
        $payload->setFileSize($payload->getFile()->getSize());
        $payload->setFileType($payload->getFile()->getClientMimeType());
        return $payload;
    }

    /**
     * @param FileUploadDTO $payload
     * @return FileUploadDTO
     */
    public function validate(FileUploadDTO $payload): FileUploadDTO
    {
        if (self::allowedFileExtension($payload->getFile()->getClientOriginalExtension()) ||
            self::allowedFileSize($payload->getFile()->getMaxFilesize())) {
            return $payload->setValidate(true);
        }

        return $payload;
    }

    /**
     * @param string $extension
     * @return bool
     */
    public function allowedFileExtension(string $extension): bool
    {
        return in_array($extension, $this->allowedFileTypes);
    }

    /**
     * @param int $fileSize
     * @return bool
     */
    public function allowedFileSize(int $fileSize): bool
    {
        return ($fileSize < $this->allowedFileSize);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getOwnFileUpload(int $userId): Collection
    {
        return $this->repository->getFileUploadByUserId($userId);
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getOwnInformation(int $userId): array
    {
        $information = self::getOwnFileUpload($userId)->whereNotNull('file_path');

        if ($information->isEmpty()) {
            return [];
        }

        $totalFile = $information->count();
        $totalSize = $information->sum('file_size');
        $fileType = $information->pluck( 'file_type', 'file_extension');
        $totalFileType = $information->pluck('file_extension')->countBy();
        $totalMimeType = [];
        foreach ($totalFileType as $type => $countFile) {
            $totalMimeType[$type] = $information->where('file_extension', $type)->sum('file_size');
        }

        return [
            'file_type' => $fileType,
            'total_size' => $totalSize,
            'total_file' => $totalFile,
            'total_file_type' => $totalFileType,
            'total_mime_type' => $totalMimeType
        ];
    }
}
