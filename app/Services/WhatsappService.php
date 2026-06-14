<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    public static function sendToAdmin(string $message): bool
    {
        $token  = config('services.fonnte.token');
        $target = config('services.fonnte.admin_number');

        if (!$token || !$target) {
            Log::warning('Fonnte token/number not configured.');
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target'  => $target,
                'message' => $message,
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Fonnte send failed: ' . $e->getMessage());
            return false;
        }
    }
}