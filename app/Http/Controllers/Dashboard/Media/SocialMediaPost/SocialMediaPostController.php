<?php

namespace App\Http\Controllers\Dashboard\Media\SocialMediaPost;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\SocialMediaPost\{DownloadSocialMediaPostImagesRequest , ApproveSocialMediaPostRequest, ProofreadSocialMediaPostRequest, CreateSocialMediaPostRequest, RejectSocialMediaPostRequest, UpdateSocialMediaPostPublishingOptions, UpdateSocialMediaPostRequest, ArchiveSocialMediaPostRequest, CreateSocialMediaPostImageRequest, DeleteSocialMediaPostImageRequest};
use App\Models\{SocialMediaPost};
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class SocialMediaPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function list(Request $request)
    {
        try {
            return response()->json(SocialMediaPost::orderBy('id', 'desc')->where(function ($q) use ($request) {
                if ($request->has('q')) {
                    $q->where('body->ar->value', 'like', '%' . $request->q . '%');
                }
                foreach ($request->all() as $key => $value) {
                    if (Schema::hasColumn(SocialMediaPost::getTableName(), $key)) {
                        $q->whereNotNull($key);
                    }
                    if ($key == 'proofread' && $value == true) {
                        $q->where('body->ar->proofread', true);
                        $q->where('body->en->proofread', true);
                    }
                    if ($key == 'status' && $value != 'all') {
                        $q->where('status', $value);
                    }
                    if ($key == 'ready_to_publish' && $value = true) {
                        $q->where('ready_to_publish', 1);
                    }
                }
            })->paginate(10)->withQueryString());
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function create(CreateSocialMediaPostRequest $request)
    {
        try {
            $socialMediaPost = SocialMediaPost::create($request->validated());
            return response()->json($socialMediaPost);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function retrieve($id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function update(UpdateSocialMediaPostRequest $request)
    {
        try {
            $socialMediaPost = SocialMediaPost::findOrFail($request->id);
            $socialMediaPost->updateContentFields($request->validated());
            $socialMediaPost->update(['description' => $request->validated()['description']]);
            return response()->json($socialMediaPost);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsProofread(ProofreadSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->markAsProofread('ar'));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function markAsRejected(RejectSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->update(['status' => 'rejected', 'rejected_at' => date('Y-m-d H:i:s', time()), 'rejected_by' => auth()->id()]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function markAsApproved(ApproveSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->update(['status' => 'approved', 'approved_at' => date('Y-m-d H:i:s', time()), 'approved_by' => auth()->id()]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function updateSocialMediaPostPublishingOptions(UpdateSocialMediaPostPublishingOptions $request, $id)
    {
        $post = SocialMediaPost::findOrFail($id);
        foreach ($request->validated()['publishing'] as $type => $value) {
            if ($value == true && $post->$type == null) {
                $post->$type = date('Y-m-d H:i:s', time());
            } elseif ($value == false) {
                $post->$type = null;
            }
        }
        foreach ($request->validated()['scheduling'] as $key => $val) {
            if ($val) $post->$key = $val;
            else $post->$key = null;
        }
        $post->save();
        return response()->json(null);
    }

    public function markAsArchived(ArchiveSocialMediaPostRequest $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->update(['archived_at' => date('Y-m-d H:i:s', time())]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function listSocialMediaPostImages(Request $request, $id)
    {
        try {
            return response()->json(SocialMediaPost::findOrFail($id)->images()->paginate(100));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function createSocialMediaPostImage(CreateSocialMediaPostImageRequest $request, $id)
    {
        try {
            $socialMediaPost = SocialMediaPost::findOrFail($id);
            foreach ($request->validated()['images'] as $image) {
                $socialMediaPost->images()->create(["image" => $image, "type" => "image"]);
            }
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteSocialMediaPostImage(DeleteSocialMediaPostImageRequest $request, $id, $image_id)
    {
        try {
            SocialMediaPost::findOrFail($id)->images()->where('id', $image_id)->delete();
            return response()->json(null);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function downloadImages(DownloadSocialMediaPostImagesRequest $request, $id)
    {
        try {
            
            $socialMediaPost = SocialMediaPost::findOrFail($id);
            $time = time();
            $tempFolderPath = 'temp/media_'.$socialMediaPost->id .'_'.$time;

            $foldePath = storage_path('app/'.$tempFolderPath);
            $zipFolder = storage_path('app/public/'.$tempFolderPath.'.zip');
            foreach ($request->validated()['images'] as $image_id) {
                $image = $socialMediaPost->images()->where('id', $image_id)->first();
                $images[] = $image;
                Storage::disk('local')->put('temp/media_'.$socialMediaPost->id.'_'.$time.'/' . $image->reference . '.jpg' , file_get_contents(Storage::url('images/'.$image->reference.'.jpg')));
            }
            $zip = new ZipArchive();

            if ($zip->open($zipFolder, ZipArchive::CREATE) === TRUE) {
                foreach(glob($foldePath.'/*.jpg') as $file)
                {
                    if (! $zip->addFile($file, basename($file))) {
                        echo 'Could not add file to ZIP: ' . $file;
                    }
                }
                $zip->close();
            } else {
            } 
            Storage::disk('local')->deleteDirectory($tempFolderPath );
            return response()->json(['url' => Storage::disk('local')->url($tempFolderPath . '.zip')]);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
