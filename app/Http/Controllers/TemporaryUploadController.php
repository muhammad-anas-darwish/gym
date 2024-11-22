<?php

namespace App\Http\Controllers;

use App\Models\TemporaryUpload;
use Illuminate\Http\Request;

class TemporaryUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048',
        ]);

        $temporaryUpload = TemporaryUpload::create([
            'token' => uniqid(),
        ]);

        $temporaryUpload
            ->addMedia($request->file('file'))
            ->toMediaCollection();

        return $this->successResponse([
            'token' => $temporaryUpload->token
        ], 200, 'File uploaded successfully!');
    }
}
