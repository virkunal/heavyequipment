<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadBoomLiftImages extends Command
{
    protected $signature = 'boom-lifts:download-images';

    protected $description = 'Download sample images for boom lifts from the internet';

    public function handle(): int
    {
        $this->info('Downloading boom lift images...');

        $imageUrls = [
            'https://picsum.photos/800/600?random=1',
            'https://picsum.photos/800/600?random=2',
            'https://picsum.photos/800/600?random=3',
            'https://picsum.photos/800/600?random=4',
            'https://picsum.photos/800/600?random=5',
            'https://picsum.photos/800/600?random=6',
            'https://picsum.photos/800/600?random=7',
            'https://picsum.photos/800/600?random=8',
            'https://picsum.photos/800/600?random=9',
            'https://picsum.photos/800/600?random=10',
        ];

        $downloadedImages = [];
        $directory = 'boom-lifts';

        if (! Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        foreach ($imageUrls as $index => $url) {
            try {
                $this->info('Downloading image '.($index + 1).'/'.count($imageUrls).'...');

                $response = Http::timeout(30)->get($url);

                if ($response->successful()) {
                    $filename = 'boom-lift-'.($index + 1).'.jpg';
                    $path = $directory.'/'.$filename;

                    Storage::disk('public')->put($path, $response->body());
                    $downloadedImages[] = $path;

                    $this->info("✓ Downloaded: {$filename}");
                } else {
                    $this->warn('✗ Failed to download image '.($index + 1));
                }
            } catch (\Exception $e) {
                $this->error('✗ Error downloading image '.($index + 1).': '.$e->getMessage());
            }
        }

        $this->info("\n✓ Successfully downloaded ".count($downloadedImages)." images to storage/app/public/{$directory}/");

        return Command::SUCCESS;
    }
}
