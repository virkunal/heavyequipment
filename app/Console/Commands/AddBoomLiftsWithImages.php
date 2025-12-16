<?php

namespace App\Console\Commands;

use App\Models\BoomLift;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AddBoomLiftsWithImages extends Command
{
    protected $signature = 'boom-lifts:add-with-images {count=20}';

    protected $description = 'Download images and create boom lift records with images';

    public function handle(): int
    {
        $count = (int) $this->argument('count');
        $this->info("Creating {$count} boom lift records with images...");

        $directory = 'boom-lifts';

        if (! Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        // Get existing images to find the next number
        $existingFiles = Storage::disk('public')->files($directory);
        $nextImageNumber = count($existingFiles) + 1;

        $created = 0;

        for ($i = 0; $i < $count; $i++) {
            try {
                // Download image
                $imageNumber = $nextImageNumber + $i;
                $imageUrl = "https://picsum.photos/800/600?random={$imageNumber}";

                $this->info("Downloading image {$imageNumber}...");

                $response = Http::timeout(30)->get($imageUrl);

                if ($response->successful()) {
                    $filename = "boom-lift-{$imageNumber}.jpg";
                    $imagePath = $directory.'/'.$filename;

                    Storage::disk('public')->put($imagePath, $response->body());

                    // Create boom lift record with image
                    BoomLift::factory()->create([
                        'image' => $imagePath,
                    ]);

                    $created++;
                    $this->info("✓ Created boom lift {$created}/{$count} with image: {$filename}");
                } else {
                    $this->warn("✗ Failed to download image {$imageNumber}");
                }
            } catch (\Exception $e) {
                $this->error("✗ Error: {$e->getMessage()}");
            }
        }

        $this->info("\n✓ Successfully created {$created} boom lift records with images!");

        return Command::SUCCESS;
    }
}
