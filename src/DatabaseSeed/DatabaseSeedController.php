<?php

namespace AdevPmftc\NovaArtisanCards\DatabaseSeed;

use AdevPmftc\NovaArtisanCards\DatabaseSeed\Requests\DatabaseSeedRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DatabaseSeedController extends Controller
{
    public function seed(DatabaseSeedRequest $databaseSeedRequest): JsonResponse
    {
        $seederClass = $databaseSeedRequest->get('seederClass', 'DatabaseSeeder');

        $command = ['php', base_path('artisan'), 'db:seed'];
        if ($seederClass !== 'DatabaseSeeder') {
            $command[] = '--class=' . $seederClass;
        }

        $process = new Process($command);

        try {
            $process->mustRun();

            return response()->json([
                'success' => true,
                'message' => 'Database seeded successfully.',
                'output' => $process->getOutput()
            ]);
        } catch (ProcessFailedException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to run database seeder.',
                'error' => $exception->getMessage(),
                'output' => $process->getOutput()
            ], 500);
        }
    }
}
