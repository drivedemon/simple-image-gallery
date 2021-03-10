<?php

namespace Tests\Unit\FileUpload;

use App\Domain\FileUpload\FileUploadDTO;
use App\Domain\FileUpload\FileUploadRepository;
use App\Domain\FileUpload\FileUploadService;
use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileUploadServiceTest extends TestCase
{
    /**
     * @var Collection|Model|mixed
     */
    private $user;
    /**
     * @var UploadedFile
     */
    private $generalFile;
    /**
     * @var UploadedFile
     */
    private $zipFile;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->generalFile = new UploadedFile(
            __DIR__ . '/Images/image.jpg',
            'image.jpg',
            'image/jpeg',
            null,
            false,
            true
        );
        $this->zipFile = new UploadedFile(
            __DIR__ . '/Images/example.zip',
            'example.zip',
            'application/zip',
            null,
            false,
            true
        );
    }

    protected function getDTO($request): FileUploadDTO
    {
        return new FileUploadDTO($request);
    }

    protected function getRepository()
    {
        return $this->createMock(FileUploadRepository::class);
    }

    protected function getService($repository): FileUploadService
    {
        return new FileUploadService($repository);
    }

    /**
     * @test
     */
    public function shouldCreatedFileUpload()
    {
        $request = app('request')->merge(['file' => $this->generalFile, 'user_id' => $this->user->id]);
        $fileUpload = FileUpload::factory()->create();

        $repository = $this->getRepository();
        $repository->expects($this->once())
            ->method('createFileUpload')
            ->willReturn($fileUpload);

        $service = $this->getService($repository);
        $response = $service->createFileUpload(new FileUploadDTO($request));
        $this->assertInstanceOf(FileUpload::class, $response);
    }

    /**
     * @test
     */
    public function shouldGetEmptyInformation()
    {
        $collection = FileUpload::whereUserId($this->user->id)->get();
        $repository = $this->getRepository();
        $repository->expects($this->once())
            ->method('getFileUploadByUserId')
            ->willReturn($collection);

        $service = $this->getService($repository);
        $response = $service->getOwnInformation($this->user->id);
        $this->assertEmpty($response);
    }

    /**
     * @test
     */
    public function shouldGetInformation()
    {
        $fileUpload = FileUpload::factory()->create();
        $collection = FileUpload::whereUserId($fileUpload->user_id)->get();

        $repository = $this->getRepository();
        $repository->expects($this->once())
            ->method('getFileUploadByUserId')
            ->willReturn($collection);

        $service = $this->getService($repository);
        $response = $service->getOwnInformation($fileUpload->user_id);

        $this->assertArrayHasKey('file_type', $response);
        $this->assertArrayHasKey('total_size', $response);
        $this->assertArrayHasKey('total_file', $response);
        $this->assertArrayHasKey('total_file_type', $response);
        $this->assertArrayHasKey('total_mime_type', $response);
    }

    /**
     * @test
     */
    public function shouldValidated()
    {
        $request = app('request')->merge(['file' => $this->generalFile]);
        $payload = $this->getDTO($request);

        $service = $this->getService($this->getRepository());
        $service->validate($payload);

        $this->assertTrue($payload->getValidate());
    }

    /**
     * @test
     */
    public function shouldNotValidated()
    {
        $request = app('request')->merge(['file' => $this->zipFile]);
        $payload = $this->getDTO($request);

        $service = $this->getService($this->getRepository());
        $service->validate($payload);

        $this->assertFalse($payload->getValidate());
    }
}
