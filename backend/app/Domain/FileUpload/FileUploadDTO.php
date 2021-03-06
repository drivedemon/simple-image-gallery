<?php

namespace App\Domain\FileUpload;

use App\Domain\DTO;
use Illuminate\Http\UploadedFile;

/**
 * Class FileUploadDTO
 * @package App\Domain\FileUpload
 */
class FileUploadDTO extends DTO
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var int
     */
    protected $userId;
    /**
     * @var UploadedFile
     */
    protected $file;
    /**
     * @var string
     */
    protected $filePath;
    /**
     * @var string
     */
    protected $fileName;
    /**
     * @var string
     */
    protected $fileExtension;
    /**
     * @var int
     */
    protected $fileSize;
    /**
     * @var string
     */
    protected $fileType;
    /**
     * @var bool
     */
    protected $validate = false;
    /**
     * @var string
     */
    protected $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * @return bool
     */
    public function getValidate(): bool
    {
        return $this->validate;
    }

    /**
     * @param bool $validate
     * @return FileUploadDTO
     */
    public function setValidate(bool $validate): FileUploadDTO
    {
        $this->validate = $validate;
        return $this;
    }

    /**
     * @param string $filePath
     * @return FileUploadDTO
     */
    public function setFilePath(string $filePath): FileUploadDTO
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string $extension
     * @return FileUploadDTO
     */
    public function setFileExtension(string $extension): FileUploadDTO
    {
        $this->fileExtension = $extension;
        return $this;
    }

    /**
     * @param string $clientOriginalName
     * @return FileUploadDTO
     */
    public function setFileName(string $clientOriginalName): FileUploadDTO
    {
        $this->fileName = $clientOriginalName;
        return $this;
    }

    /**
     * @param int $size
     * @return FileUploadDTO
     */
    public function setFileSize(int $size): FileUploadDTO
    {
        $this->fileSize = $size;
        return $this;
    }

    /**
     * @param string $mimeType
     * @return FileUploadDTO
     */
    public function setFileType(string $mimeType): FileUploadDTO
    {
        $this->fileType = $mimeType;
        return $this;
    }
}
