<?php

namespace App\Traits;

use App\Models\Images;
use Illuminate\Support\Facades\Storage;

trait AttachFiles
{
    public function uploadFile($file, $model, $folder)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('attachments/' . $folder . '/' . $model->id, $fileName, 'uploads');

        $model->images()->create([
            'filename' => $fileName,
        ]);
    }

    public function deleteFile($id, $folder)
    {
        $path = 'attachments/' . $folder . '/' . $id;

        Storage::disk('uploads')->deleteDirectory($path);
        Images::where('imageable_id', $id)->delete();
    }
}
