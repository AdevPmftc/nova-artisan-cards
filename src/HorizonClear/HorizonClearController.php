<?php

namespace AdevPmftc\NovaArtisanCards\HorizonClear;

use AdevPmftc\NovaArtisanCards\HorizonClear\Requests\HorizonClearRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class HorizonClearController extends Controller
{
    public function clear(HorizonClearRequest $horizonClearRequest): JsonResponse
    {
        $queue = $horizonClearRequest->get('queue', 'default');

        $command = ['php', base_path('artisan'), 'horizon:clear'];
        if ($queue !== 'default') {
            $command[] = '--queue=' . escapeshellarg($queue);
        }

        $process = new Process($command);

        try {
            $process->mustRun();

            return response()->json([
                'success' => true,
                'message' => 'Horizon queue cleared successfully.',
                'output' => $process->getOutput()
            ]);
        } catch (ProcessFailedException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear Horizon queue.',
                'error' => $exception->getMessage(),
                'output' => $process->getOutput()
            ], 500);
        }
    }
}
