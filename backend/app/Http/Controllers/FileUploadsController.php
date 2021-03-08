<?php

namespace App\Http\Controllers;

use App\Domain\FileUpload\FileUploadDTO;
use App\Domain\FileUpload\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileUploadsController extends Controller
{
    /**
     * @var FileUploadService
     */
    private FileUploadService $fileUploadService;

    /**
     * LoansController constructor.
     * @param FileUploadService $fileUploadService
     */
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        DB::beginTransaction();

        $payload = new FileUploadDTO($request);
        $this->fileUploadService->validate($payload);
        $this->fileUploadService->uploadFileStorage($payload);
        $this->fileUploadService->extractDetail($payload);
        $fileUpload = $this->fileUploadService->createFileUpload($payload);

        DB::commit();

        return $this->successResponse(['file_upload' => $fileUpload->toArray()]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function fetch(int $id): JsonResponse
    {
        return $this->successResponse(
            ['file_upload' => $this->fileUploadService->getOwnFileUpload($id)]
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function information(int $id): JsonResponse
    {
        return $this->successResponse(
            ['file_upload' => $this->fileUploadService->getOwnInformation($id)]
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $fileUpload = $this->fileUploadService->findFileUploadById($id);

        if (null === $fileUpload) {
            return $this->errorResponse('file_upload_not_found', [], 404);
        }

        if ($this->fileUploadService->deleteImage($fileUpload)) {
            return $this->successResponse();
        }

        return $this->errorResponse('unknown_error');
    }
}
