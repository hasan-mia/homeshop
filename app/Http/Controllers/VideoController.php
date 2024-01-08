<?php

namespace App\Http\Controllers;

use App\Models\Video;
use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'video' => 'required|mimes:mp4,mov,avi|max:10240', // Adjust the allowed video formats and max size as needed
        ]);

        $videoPath = $request->file('video')->store('public/videos');
        $videoUrl = asset(str_replace('public/', 'storage/', $videoPath));

        // Convert the video to HLS format
        $hlsPath = $this->convertToHLS($videoPath);

        $hlsUrl = asset(str_replace('public/', 'storage/', $hlsPath));

        $videoData = [
            'video_url' => $videoUrl,
            'hls_url' => $hlsUrl,
        ];

        // Store the original video URL and HLS URL in the database
        Video::create($videoData);

        return response()->json($videoData, 201);
    }

    private function convertToHLS($videoPath)
    {
        // Use FFMpeg or another video conversion library to convert the video to HLS format
        // Example using FFMpeg (you need to install the FFMpeg package):
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open(storage_path("app/$videoPath"));

        $hlsPath = str_replace('public/videos', 'public/hls', $videoPath) . '.m3u8';
        $video->hls()->save($hlsPath);

        return $hlsPath;
    }
}
