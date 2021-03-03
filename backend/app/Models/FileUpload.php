<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    const USER_ID = 'user_id';
    const FILE_PATH = 'file_path';
    const FILE_NAME = 'file_name';
    const FILE_EXTENSION = 'file_extension';
    const FILE_SIZE = 'file_size';
    const FILE_TYPE = 'file_type';

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
