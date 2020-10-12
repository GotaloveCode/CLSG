<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'document_type'];

    public function attachable()
    {
        return $this->morphTo();
    }

    /**
     *  Delete file and remove upload entry
     *
     * @param Attachment $attachment
     */
    public static function remove(Attachment $attachment)
    {
        $filename = $attachment->name;
        $path = storage_path('app/Eoi/' . $filename);

        if (File::exists($path)) {
            File::delete($path);
        }
        $attachment->delete();
    }

}
