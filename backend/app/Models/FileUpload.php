<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    const ID = 'id';
    const USER_ID = 'user_id';
    const FILE_PATH = 'file_path';
    const FILE_NAME = 'file_name';
    const FILE_EXTENSION = 'file_extension';
    const FILE_SIZE = 'file_size';
    const FILE_TYPE = 'file_type';

    const ALLOWED_FILE_SIZE = 10485760;
    const DEFAULT_STORAGE_PATH = 'public/';
    const EXCEPT_PARAMETERS = ['file', 'validate'];
    const ALLOWED_FILE_TYPE = ['jpg', 'png'];

    /**
     * @var array
     */
    protected $fillable = [
        self::USER_ID,
        self::FILE_PATH,
        self::FILE_NAME,
        self::FILE_EXTENSION,
        self::FILE_SIZE,
        self::FILE_TYPE,
    ];
}
