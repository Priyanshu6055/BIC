<?php

namespace App\Http\Controllers;

use App\Mail\InquiryThankYouMail;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InquiryController extends Controller
{
    private const TYPES = ['startup', 'msme', 'investor', 'ma', 'contact'];

    public function create(string $type): View
    {
        abort_unless(in_array($type, self::TYPES, true), 404);

        return view('inquiries.create', ['type' => $type, 'config' => config("inquiries.$type")]);
    }

    public function store(Request $request, string $type): JsonResponse|RedirectResponse
    {
        abort_unless(in_array($type, self::TYPES, true), 404);
        $validated = $request->validate($this->rules($type));

        foreach (['declaration', 'consent', 'newsletterConsent'] as $booleanField) {
            $validated[$booleanField] = $request->boolean($booleanField);
        }

        if (($validated['companyFax'] ?? '') !== '') {
            abort(422, 'Submission rejected.');
        }

        $reference = $this->reference();
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->storeAs(
                "inquiries/$reference",
                Str::random(40).'.pdf',
                'local'
            );
        }

        $payload = Arr::except($validated, ['document', 'companyFax']);
        $inquiry = Inquiry::create([
            'reference' => $reference,
            'type' => $type,
            'name' => $payload['founderName'] ?? $payload['contactName'] ?? $payload['name'] ?? '',
            'email' => $payload['email'],
            'phone' => $payload['mobile'],
            'company' => $payload['company'] ?? $payload['organisation'] ?? null,
            'payload' => $payload,
            'document_path' => $documentPath,
            'status' => 'New',
        ]);

        try {
            if (! empty($inquiry->email)) {
                Mail::to($inquiry->email, $inquiry->name ?: null)
                    ->send(new InquiryThankYouMail($inquiry));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send thank-you email for inquiry '.$inquiry->reference.': '.$e->getMessage(), [
                'exception' => $e,
            ]);
        }

        $response = ['status' => 'success', 'message' => 'Your inquiry has been received.', 'reference' => $inquiry->reference];
        return $request->expectsJson()
            ? response()->json($response, 201)
            : back()->with('submission', $response);
    }

    private function reference(): string
    {
        do {
            $reference = 'BIC-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Inquiry::where('reference', $reference)->exists());
        return $reference;
    }

    private function rules(string $type): array
    {
        $text = fn (int $max = 160) => ['required', 'string', "max:$max"];
        $url = ['nullable', 'url', 'max:254'];
        $base = [
            'email' => ['required', 'email:rfc', 'max:254'],
            'mobile' => ['required', 'regex:/^\\+?[0-9][0-9 ()-]{6,19}$/'],
            'declaration' => ['accepted'],
            'consent' => ['accepted'],
            'newsletterConsent' => ['sometimes', 'boolean'],
            'companyFax' => ['nullable', 'max:0'],
            'document' => ['nullable', 'file', 'mimetypes:application/pdf', 'mimes:pdf', 'max:10240'],
        ];
        $specific = match ($type) {
            'startup' => [
                'founderName' => $text(), 'company' => $text(), 'designation' => $text(),
                'website' => $url, 'linkedIn' => $url, 'city' => $text(100), 'sector' => $text(120),
                'businessStage' => ['required', Rule::in(['early-revenue','growth','scale','other'])],
                'tractionSummary' => $text(1200),
                'capitalSought' => ['required', Rule::in($this->ranges())], 'capitalUse' => $text(800),
            ],
            'msme' => [
                'contactName' => $text(), 'company' => $text(), 'designation' => $text(),
                'website' => $url, 'city' => $text(100), 'industry' => $text(120),
                'businessAge' => ['required', Rule::in(['under-3','3-7','8-15','15-plus'])],
                'revenueRange' => ['required', Rule::in($this->ranges())],
                'capitalRequirement' => ['required', Rule::in($this->ranges())],
                'capitalPurpose' => $text(800),
            ],
            'investor' => [
                'name' => $text(), 'organisation' => $text(), 'designation' => $text(),
                'linkedIn' => $url, 'location' => $text(120),
                'investorType' => ['required', Rule::in(['individual','family-office','corporate','fund','other'])],
                'preferredSectors' => $text(400), 'preferredStage' => $text(160),
                'ticketSize' => ['required', Rule::in($this->ranges())],
                'strategicCapabilities' => $text(800),
            ],
            'ma' => [
                'contactName' => $text(), 'organisation' => $text(), 'designation' => $text(),
                'website' => $url,
                'transactionSide' => ['required', Rule::in(['sell-side','buy-side','partnership','exploratory'])],
                'transactionType' => $text(120), 'sector' => $text(120), 'geography' => $text(160),
                'transactionRange' => ['required', Rule::in($this->ranges())],
                'confidentialSummary' => $text(1200),
            ],
            'contact' => [
                'name' => $text(), 'organisation' => $text(160),
                'inquiryCategory' => ['required', Rule::in(['startup','msme','investor','ma','other'])],
                'message' => $text(1200),
            ],
        };
        if (! in_array($type, ['startup', 'msme', 'ma'], true)) {
            unset($base['document']);
        }
        return array_merge($base, $specific);
    }

    private function ranges(): array
    {
        return ['under-1cr', '1-5cr', '5-25cr', '25cr-plus', 'discuss'];
    }
}
