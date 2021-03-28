<?php

namespace App\Console\Commands;

use App\Models\Videos;
use Carbon\Carbon;
use FFMpeg\FFMpeg;
use Illuminate\Console\Command;
use Str;

class ProcessVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videos:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all videos for database storage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mediaDir = base_path() . '/media' . '/videos/';
        $thumbnailDir = base_path() . '/public_html/images/thumbnails/';
        $videoFiles = scandir($mediaDir);
        $videoFiles = array_slice($videoFiles, 2, count($videoFiles));

        if (! empty($videoFiles)) {
            foreach ($videoFiles as $video) {
                preg_match_all("^\[(.*?)\]^", $video, $date, PREG_PATTERN_ORDER);

                $authorOriginal = preg_split('/(?<match>by\s)/', $video, -1, PREG_SPLIT_NO_EMPTY);
                $author = explode('-', $authorOriginal[1]);
                $author = $author[0];

                $title = ltrim(str_replace([$date[0][0], 'by ' . $authorOriginal[1], '.mp4'], ['', '', ''], $video));

                $dateTime = explode(' ', $date[1][0]);
                $dateTime = Carbon::createFromFormat(
                    'Y/m/d H:i:s',
                    str_replace('_', '/', $dateTime[0]) . ' ' . str_replace('_', ':', $dateTime[1])
                );

                $videoEntry = Videos::where('title', $title)->where('created', $dateTime)->first();

                if (! $videoEntry) {
                    $thumbnailName = Str::slug($title . $dateTime->toDateTimeString() . '-thumbnail') . '.jpg';

                    if (! file_exists($thumbnailDir . $thumbnailName)) {
                        $ffmpeg = \FFMpeg\FFMpeg::create();
                        $videoFile = $ffmpeg->open($mediaDir . $video);
                        $thumbnail = $videoFile->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(2));
                        $thumbnail->save($thumbnailDir . $thumbnailName);
                    }

                    $ffprobe = \FFMpeg\FFProbe::create();
                    $duration = number_format($ffprobe->format($mediaDir . $video)->get('duration'));

                    Videos::factory()->create([
                        'title'     => $title,
                        'author'    => $author,
                        'filename'  => $video,
                        'created'   => $dateTime,
                        'duration'  => $duration,
                        'thumbnail' => $thumbnailName,
                    ]);
                }
            }
        }

        return 0;
    }
}
