<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'document_type'];

    protected $dates = ['created_at', 'updated_at'];

    public function attachable()
    {
        return $this->morphTo();
    }

    /**
     *  Delete file and remove upload entry
     *
     * @param Attachment $attachment
     * @param $path_prefix
     * @throws \Exception
     */
    public static function remove(Attachment $attachment, $path_prefix)
    {
        $filename = $attachment->name;
        $path = storage_path($path_prefix . $filename);

        if (File::exists($path)) {
            File::delete($path);
        }
        $attachment->delete();
    }

}
