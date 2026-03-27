<?php

namespace App\Jobs;

use App\Models\Recommendation;
use App\Models\Plat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnalyzeRecommendationJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected $recommendationId;

    public function __construct($recommendationId)
    {
        $this->recommendationId = $recommendationId;
    }

    public function handle()
    {
        $recommendation = Recommendation::find($this->recommendationId);
        if (!$recommendation) return;

        $user = $recommendation->user;
        $plate = Plat::with('ingredients')->find($recommendation->plate_id);

        if (!$plate) return;

         $restrictions = implode(', ', $user->dietary_tags ?? []);

        $ingredients = $plate->ingredients
            ->pluck('tags')
            ->filter()
            ->flatten()
            ->implode(', ');

        $prompt = <<<PROMPT
Analyze the nutritional compatibility between this dish and the user's dietary restrictions.

DISH: {$plate->name}
INGREDIENT TAGS: {$ingredients}
USER RESTRICTIONS: {$restrictions}

Tag mapping rules:
"vegan" restriction conflicts with: contains_meat, contains_lactose
"no_sugar" restriction conflicts with: contains_sugar
"no_cholesterol" restriction conflicts with: contains_cholesterol
"gluten_free" restriction conflicts with: contains_gluten
"no_lactose" restriction conflicts with: contains_lactose

Scoring rule:
Start at 100 and subtract 25 points for each conflict.

Respond ONLY with valid JSON:
{
  "score": number,
  "label": "string",
  "warning_message": "string"
}
PROMPT;

        try {
            $aiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_KEY'),
            ])->post(env('HUGGINGFACE_API_URL'), [
                'inputs' => $prompt
            ]);

            $text = '';

            if ($aiResponse->successful()) {
                $data = $aiResponse->json();
                $text = $data[0]['generated_text'] ?? '';
            }

            Log::info('AI raw response', ['text' => $text]);


            $text = preg_replace('/```json|```/', '', $text);
            $text = trim($text);

            preg_match('/\{.*\}/s', $text, $matches);
            $data = json_decode($matches[0] ?? '{}', true);

            $score = max(0, min(100, (int) ($data['score'] ?? 50)));

            $label = match (true) {
                $score >= 80 => ' Highly Recommended',
                $score >= 50 => ' Recommended with notes',
                default      => ' Not Recommended',
            };

            $warning = $data['warning_message'] ?? null;

        } catch (\Exception $e) {

            Log::error('AI request failed', [
                'error' => $e->getMessage()
            ]);

            $score = 50;
            $label = ' Recommended with notes';
            $warning = 'Erreur IA';
        }

        $recommendation->update([
            'score' => $score,
            'label' => $label,
            'warning_message' => $score < 50 ? $warning : null,
            'status' => 'ready'
        ]);
    }
}