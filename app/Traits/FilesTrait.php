<?php

namespace App\Traits;



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
}
