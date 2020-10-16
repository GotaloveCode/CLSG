<?php

namespace App\Http\Controllers;

use App\Imports\WspsImport;
use App\Models\Eoi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class WspController extends Controller
{
    public function import_view(Request $request)
    {
        if ($request->get('export-csv') == 'export') {
            $path = storage_path("app/wsps.xlsx");
            if (File::exists($path)) {
                return response()->file($path, [
                    'Content-Disposition' => 'download; filename="wsps.xlsx"'
                ]);
            }
        }
        return view('wsps.import');
    }

    public function import(Request $request)
    {
        return $this->importer($request, new WspsImport());
    }

    private function importer(Request $request,$importable)
    {
        if (!$request->hasFile('file')) {
            return redirect()->back()
                ->withErrors([
                    'file' => ["Please upload a file"]
                ]);
        }
        $ext = $request->file('file')->getClientOriginalExtension();

        $valid = Validator::make(['extension' => $ext],
            ['extension' => "in:xlsx,xls"]);

        if ($valid->fails())
            return redirect()->back()
                ->withErrors([
                    'file' => ["invalid file type uploaded. please upload an excel file or a csv file"]
                ]);
        $file = $request->file('file');

        try {

            Excel::import($importable, $file);

            return redirect()->back()
                ->with('alerts', [
                    ['type' => 'success', 'message' => "Customers imported successfully"]
                ]);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $err = "";
            foreach ($failures as $failure) {
                $err .= "Row:{$failure->row()} {$failure->attribute()} {$failure->errors()}. Wrong value: {$failure->values()} \n";
            }
            Log::error($err);
            return redirect()->back()
                ->with('alerts', [
                    ['type' => 'danger', 'message' => "Sorry error occurred. {$err}"]
                ]);
        } catch (Exception $e) {
            Log::error("Exception: " . $e);
            $errors = '';
            if ($e instanceOf \Illuminate\Validation\ValidationException) {
                foreach ($e->errors() as $key => $value) {
                    $errors .= $value[0];
                }
            } else {
                $errors = $e->getMessage();
            }
            Log::error(get_class($importable). " import exception: " . $errors);
            return redirect()->back()
                ->with('alerts', [
                    ['type' => 'danger', 'message' => "Sorry error occurred : " . $errors]
                ]);
        } catch (\Throwable $e) {
            Log::error(get_class($importable). " import error: " . $e->getMessage(), ["error" => $e]);
            return redirect()->back()
                ->with('alerts', [
                    ['type' => 'danger', 'message' => "Check your file. Sorry an error occurred." . $e->getMessage()]
                ]);
        }
    }


}
