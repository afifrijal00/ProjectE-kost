<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array',
        ]);

        // Ambil data kamar available dari DB
        $rooms = Room::where('status', 'available')
            ->get(['room_number', 'type', 'price', 'facilities']);

        $roomContext = $rooms->map(function ($room) {
            $facilities = is_array($room->facilities)
                ? implode(', ', $room->facilities)
                : $room->facilities;
            return "- Kamar {$room->room_number} (Tipe: {$room->type}): Rp " .
                number_format($room->price, 0, ',', '.') . "/bulan | Fasilitas: {$facilities}";
        })->join("\n");

        $systemPrompt = "Kamu adalah asisten virtual e-Kost, sebuah kost modern untuk mahasiswa di Purwokerto. "
            . "Tugasmu membantu calon penyewa yang mengunjungi website dengan ramah, singkat, dan informatif.\n\n"
            . "Data kamar yang tersedia saat ini:\n{$roomContext}\n\n"
            . "Informasi umum e-Kost:\n"
            . "- Lokasi strategis dekat pusat kota Purwokerto\n"
            . "- Fasilitas umum: High-Speed WiFi, 24/7 Security CCTV, Communal Area, Kitchen & Pantry\n"
            . "- Pembayaran bulanan, bisa booking online lewat website\n"
            . "- Untuk melihat detail kamar dan booking: kunjungi menu Lihat Kamar\n"
            . "- Untuk pertanyaan lebih lanjut: hubungi kami via halaman Kontak\n\n"
            . "Aturan:\n"
            . "- Jawab dalam Bahasa Indonesia yang santai tapi sopan\n"
            . "- Jawaban singkat, maksimal 3-4 kalimat\n"
            . "- Jika ditanya hal di luar e-Kost, arahkan kembali ke topik kost\n"
            . "- Jangan mengarang data yang tidak ada di atas";

        // Bangun history untuk Gemini (format contents)
        $contents = [];

        // Tambah system prompt sebagai pesan pertama user+model
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $systemPrompt]]
        ];
        $contents[] = [
            'role' => 'model',
            'parts' => [['text' => 'Siap! Saya akan membantu calon penyewa e-Kost dengan informasi yang tersedia.']]
        ];

        // Tambah history sebelumnya
        if ($request->history) {
            foreach ($request->history as $chat) {
                if (isset($chat['role'], $chat['content'])) {
                    $contents[] = [
                        'role' => $chat['role'] === 'user' ? 'user' : 'model',
                        'parts' => [['text' => $chat['content']]]
                    ];
                }
            }
        }

        // Tambah pesan user sekarang
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $request->message]]
        ];

        $apiKey = config('services.gemini.key');

        $response = Http::post(
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
            ['contents' => $contents]
        );

        if ($response->failed()) {
            return response()->json(['reply' => 'Maaf, chatbot sedang tidak tersedia. Silakan coba lagi.'], 500);
        }

        $reply = $response->json('candidates.0.content.parts.0.text', 'Maaf, saya tidak mengerti pertanyaanmu.');

        return response()->json(['reply' => $reply]);
    }
}