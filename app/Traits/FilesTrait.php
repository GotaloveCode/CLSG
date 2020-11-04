<?php

namespace App\Traits;



use App\Models\Attachment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

trait FilesTrait
{
    function safeFileName($file)
    {
        $file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $file);
        $file = mb_ereg_replace("([\.]{2,})", '', $file);
        return $file;
    }

     function storeDocument($doc, $title, $path='app/Eoi')
    {
        
       $destinationPath = storage_path($path);
           
        if ($doc->isValid()) {

            $extension = $doc->getClientOriginalExtension();

            $fileName = $this->safeFileName($title . '-' . date('Ymd H is') . '.' . $extension);

            $doc->move($destinationPath, $fileName);

            return $fileName;
        }

        return null;
    }

    function showFile($path)
    {
        if (!File::exists($path)) {
            abort(404);
        }

        if (request()->has('download')) {
            return Response::download($path);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);


        return $response;
    }

    function deleteAttachment(Attachment $attachment,$path_prefix)
    {
        Attachment::remove($attachment,$path_prefix);

        if (request()->ajax()) {
            return response()->json(['message' => "Attachment deleted successfully!"]);
        }

        return back()->with(['message' => "Attachment deleted successfully!"]);
    }
}
