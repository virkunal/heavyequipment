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

        // Actual boom lift images from Google Shopping
        $boomLiftImageUrls = [
            'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcQ2e5kJMVK6LhyLnBrpQubk2CuLkLSXuh6XHIa8yF55YExu10Ln8mpDICgzsXeLeiVyIKaNiVXDbUcOJH8MF8YY1I0IIh32rIysSPp39ExKqLjd4fQccn1WJZ7hViv_LCgAl8cndrDoPQ&usqp=CAc',
            'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcTWeOK6HymuPWJIfp_M9mm7CanzttTfnG0hIfH3YW7BxBv3wIJvfuh0KnAIrAjqvgMUAU1tZjx0eD3LqVJF9QRTT2veI8lkIKETXdKqNU_QL0MHyLcbNYNdBWbBvMeivT83GkwjK9U&usqp=CAc',
            'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcQ6kMQ8CbJfmag5XAaNOrB8sZXpmptztdO28VNAOyJoi3K1fBixQYi8R-Xr8T309yqfsOdmKuU0xBeAIHVLy2GBkoyn-SvEGHDXSoXoBM70oRE5seJd_MKbwg&usqp=CAc',
            'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcSYLc0ECAaFPvvvV_PsueHxns6o3D-RueprVWKMsohXG_6gDDPqxlYfthD9YUb7X7V5juED6pZ5qEN7rOA_0aNOZ9Nh2PQ0HZ4WfJaH536D10dd3zy9OWMo1xGwLhZo4i_E3Ih-L6sK7w&usqp=CAc',
            'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcT7QkeK_GfgKZEf4azSqz7CNjJFii0Kf9s9-6LFCOGmpMHwhOK5cpWP4rN1u-AI0Yvl4f4hujEyI4NZ6zW3dgCIzwR8IbxmIjorFpn5eI-M4_36v0PvkXmM&usqp=CAc',
            'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcRjsOgZ4GCtL-ZI__jNtHDihrkfzt2RVW0nOwqQDCaDsKVp25ZAHG5a1ZllXipZnBVnO85SwiDlAYU_xS6BRM3zEnN_uHOH9mLdvvRlExJKUS4vobi5R1p0WQ&usqp=CAc',
            'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcTH9tgAXd5FAUnkH4-B4RaYARFQN5V0jO6C9e2e5v2kqAuIYM68X1vZARMysl2mDHMzSRUQtKpRZBPOMmdvbjnhzxH4akgQfLDS3aC6onp82I9Rf9VJr1G54WGiqTsQ9m-9YKut0gA9jGM&usqp=CAc',
            'https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcTPzbwsMyAofwG8oANi1ngD3yE_n4ZSEWjVZk2ipz_tDeDrepF-3P7Qy3etp5Dwq_os_oBufGCzE8f50AL93CpN40h2V-NNIRXaXgzbqZ3oj0e0MIXlAhRESRQgymI0oyRM9MwxK6ry&usqp=CAc',
            'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcQuxfIxL_GtbN9QMO0oN-2eZ13j9yzVDVj2VyPKjq55eyc-kte5kePTwFT1zIXdytKYwWI7C0wHMqawiB5ep37IRqMQghtzKrC_2JtmBv6yijMzfslC7Wfz-NWQqNPV&usqp=CAc',
            'https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcSYt4P-6TxuyILkPJzy3eNWF2ZdeGY8JylMIVOZBsdxcJkSrmKYzev4kDw00ITzBS0UZotlrhptappJ_SVaNX5qACVmvYE0Mb-OPr2sHZM&usqp=CAc',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSL3zInoR6j0IKFgp6DPevaW0TfOGgqCbxtMg&s',
        ];

        for ($i = 0; $i < $count; $i++) {
            try {
                $imageNumber = $nextImageNumber + $i;
                
                // Cycle through the provided boom lift image URLs
                $imageUrl = $boomLiftImageUrls[$i % count($boomLiftImageUrls)];

                $currentIndex = $i + 1;
                $this->info("Downloading boom lift image {$imageNumber} ({$currentIndex}/{$count})...");

                $response = Http::timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept' => 'image/webp,image/apng,image/*,*/*;q=0.8',
                        'Referer' => 'https://www.google.com/',
                    ])
                    ->get($imageUrl);

                if ($response->successful() && strlen($response->body()) > 100) {
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
                    $this->warn("✗ Failed to download image {$imageNumber} (Status: {$response->status()})");
                }
            } catch (\Exception $e) {
                $this->error("✗ Error downloading image {$imageNumber}: {$e->getMessage()}");
            }
        }

        $this->info("\n✓ Successfully created {$created} boom lift records with images!");

        return Command::SUCCESS;
    }
}
