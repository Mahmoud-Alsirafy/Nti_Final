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

        return $model->images()->create([
            'filename' => $fileName,
        ]);
    }

    public function deleteFile($modelOrId, $folder, $modelType = null)
    {
        $id = $modelOrId instanceof \Illuminate\Database\Eloquent\Model ? $modelOrId->id : $modelOrId;
        $path = 'attachments/' . $folder . '/' . $id;

        Storage::disk('uploads')->deleteDirectory($path);

        if ($modelOrId instanceof \Illuminate\Database\Eloquent\Model) {
            $modelOrId->images()->delete();
        } else {
            $query = Images::where('imageable_id', $id);
            if ($modelType) {
                $query->where('imageable_type', $modelType);
            } elseif ($folder === 'pet') {
                $query->where('imageable_type', \App\Models\Pet_info::class);
            } elseif ($folder === 'user') {
                $query->where('imageable_type', \App\Models\User::class);
            } elseif ($folder === 'personal') {
                $query->where('imageable_type', \App\Models\Personal_data::class);
            }
            $query->delete();
        }
    }
}
