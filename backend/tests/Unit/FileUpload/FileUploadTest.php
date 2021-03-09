<?php

namespace Tests\Unit\FileUpload;

use App\Domain\FileUpload\FileUploadRepositoryInterface;
use App\Domain\FileUpload\FileUploadService;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

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
    private $extraSizeFile;
    /**
     * @var array
     */
    private $params;
    /**
     * @var string
     */
    private $baseUri;
    /**
     * @var UploadedFile
     */
    private $zipFile;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->baseUri = '/api/upload';
        $this->params = [
            'user_id' => $this->user->id
        ];
        $this->generalFile = new UploadedFile(
            __DIR__ . '/Images/image.jpg',
            'image.jpg',
            'image/jpeg',
            null,
            false,
            true
        );
        $this->extraSizeFile = new UploadedFile(
            __DIR__.'/Images/image20mb.jpg',
            'image20mb.jpg',
            'image/jpeg',
            null,
            false,
            true
        );
        $this->zipFile = new UploadedFile(
            __DIR__.'/Images/example.zip',
            'example.zip',
            'application/zip',
            null,
            false,
            true
        );
    }

    /**
     * @param $repository
     * @return FileUploadService
     */
    protected function getService($repository): FileUploadService
    {
        return new FileUploadService($repository);
    }

    /**
     * @return FileUploadRepositoryInterface|MockObject
     */
    protected function getRepository()
    {
        return $this->createMock(FileUploadRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function shouldStoreFile()
    {
        $pathName = "{$this->user->id}/{$this->generalFile->hashName()}";
        $response = $this->call(
            'POST',
            $this->baseUri,
            $this->params,
            [],
            ['file' => $this->generalFile]
        );

        $response->assertOk();
        $response->assertJson(['is_request_success' => true]);
        $response->assertJson([
            'file_upload' => [
                'file_path' => "/storage/{$pathName}",
                'file_extension' => $this->generalFile->clientExtension()
            ]
        ]);
        Storage::disk('public')->assertExists($pathName);
    }

    /**
     * @test
     */
    public function shouldNotStoreFileWithExtraSize()
    {
        $pathName = "{$this->user->id}/{$this->extraSizeFile->hashName()}";
        $response = $this->call(
            'POST',
            $this->baseUri,
            $this->params,
            [],
            ['file' => $this->extraSizeFile]
        );

        $response->assertOk();
        $response->assertJson(['is_request_success' => true]);
        $response->assertJsonMissing([
            'file_upload' => [
                'file_path' => "/storage/{$pathName}",
            ]
        ]);
        $response->assertJson([
            'file_upload' => [
                'file_extension' => $this->extraSizeFile->clientExtension()
            ]
        ]);
        Storage::disk('public')->assertMissing($pathName);
    }

    /**
     * @test
     */
    public function shouldNotStoreFileWithOtherExtension()
    {
        $pathName = "{$this->user->id}/{$this->zipFile->hashName()}";
        $response = $this->call(
            'POST',
            $this->baseUri,
            $this->params,
            [],
            ['file' => $this->zipFile]
        );

        $response->assertOk();
        $response->assertJson(['is_request_success' => true]);
        $response->assertJsonMissing([
            'file_upload' => [
                'file_path' => "/storage/{$pathName}",
            ]
        ]);
        $response->assertJson([
            'file_upload' => [
                'file_extension' => $this->zipFile->clientExtension()
            ]
        ]);
        Storage::disk('public')->assertMissing($pathName);
    }
}
