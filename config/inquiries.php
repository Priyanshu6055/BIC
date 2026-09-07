<?php

$ranges = [
    ['value' => 'under-1cr', 'label' => 'Under ₹1 crore'],
    ['value' => '1-5cr', 'label' => '₹1–5 crore'],
    ['value' => '5-25cr', 'label' => '₹5–25 crore'],
    ['value' => '25cr-plus', 'label' => '₹25 crore or more'],
    ['value' => 'discuss', 'label' => 'Prefer to discuss'],
];
$field = fn (string $name, string $label, string $type = 'text', bool $required = false, array $extra = []) =>
    array_merge(compact('name', 'label', 'type', 'required'), $extra);
$final = function (?string $document = null) use ($field): array {
    $fields = [];
    if ($document) {
        $fields[] = $field('document', $document, 'file', false, [
            'hint' => 'Optional PDF only, maximum 10 MB. Do not include highly sensitive personal or commercial records.',
        ]);
    }
    $fields[] = $field('declaration', 'I declare that the information provided is accurate to the best of my knowledge and is appropriate for an initial inquiry.', 'checkbox', true);
    $fields[] = $field('consent', 'I consent to Bridge India Capital using this information to assess and respond to this inquiry. This does not guarantee funding, an introduction or a transaction.', 'checkbox', true);
    $fields[] = $field('newsletterConsent', 'I would also like to receive occasional BIC insights. (Optional)', 'checkbox');
    return $fields;
};
$step = fn (string $title, string $description, array $fields) => compact('title', 'description', 'fields');

return [
    'startup' => [
        'kind' => 'startup', 'title' => 'Startup capital inquiry',
        'purpose' => 'Share concise initial information so BIC can understand your business, capital objective and current stage.',
        'steps' => [
            $step('You and the business', 'Basic contact and company context.', [
                $field('founderName', 'Founder name', required: true, extra: ['autoComplete' => 'name']),
                $field('company', 'Company', required: true, extra: ['autoComplete' => 'organization']),
                $field('designation', 'Designation', required: true, extra: ['autoComplete' => 'organization-title']),
                $field('email', 'Email', 'email', true, ['autoComplete' => 'email']),
                $field('mobile', 'Mobile', 'tel', true, ['autoComplete' => 'tel']),
                $field('website', 'Website', 'url', extra: ['autoComplete' => 'url']),
                $field('linkedIn', 'LinkedIn', 'url'),
                $field('city', 'City', required: true, extra: ['autoComplete' => 'address-level2']),
            ]),
            $step('Growth context', 'The opportunity and intended use of capital.', [
                $field('sector', 'Sector', required: true),
                $field('businessStage', 'Business stage', 'select', true, ['options' => [
                    ['value'=>'early-revenue','label'=>'Early revenue'], ['value'=>'growth','label'=>'Growth'],
                    ['value'=>'scale','label'=>'Scale'], ['value'=>'other','label'=>'Other / discuss'],
                ]]),
                $field('tractionSummary', 'Brief traction summary', 'textarea', true, ['hint' => 'A concise, non-confidential summary is sufficient.']),
                $field('capitalSought', 'Capital sought range', 'select', true, ['options' => $ranges]),
                $field('capitalUse', 'Intended use of capital', 'textarea', true),
            ]),
            $step('Document and consent', 'Optional context and the permissions needed to review your inquiry.', $final('Optional pitch document')),
        ],
    ],
    'msme' => [
        'kind' => 'msme', 'title' => 'MSME equity inquiry',
        'purpose' => 'Provide broad, non-confidential information about the business and its capital requirement.',
        'steps' => [
            $step('You and the business', 'Authorised contact and company details.', [
                $field('contactName', 'Promoter or authorised contact', required: true, extra: ['autoComplete'=>'name']),
                $field('company', 'Company', required: true, extra: ['autoComplete'=>'organization']),
                $field('designation', 'Designation', required: true),
                $field('email', 'Email', 'email', true, ['autoComplete'=>'email']),
                $field('mobile', 'Mobile', 'tel', true, ['autoComplete'=>'tel']),
                $field('website', 'Website', 'url'),
                $field('city', 'City', required: true, extra: ['autoComplete'=>'address-level2']),
            ]),
            $step('Capital context', 'Broad ranges are appropriate at this stage.', [
                $field('industry', 'Industry', required: true),
                $field('businessAge', 'Business age', 'select', true, ['options' => [
                    ['value'=>'under-3','label'=>'Under 3 years'], ['value'=>'3-7','label'=>'3–7 years'],
                    ['value'=>'8-15','label'=>'8–15 years'], ['value'=>'15-plus','label'=>'More than 15 years'],
                ]]),
                $field('revenueRange', 'Broad revenue range', 'select', true, ['options'=>$ranges]),
                $field('capitalRequirement', 'Capital requirement range', 'select', true, ['options'=>$ranges]),
                $field('capitalPurpose', 'Capital purpose', 'textarea', true),
            ]),
            $step('Document and consent', 'Optional context and the permissions needed to review your inquiry.', $final('Optional introductory document')),
        ],
    ],
    'investor' => [
        'kind' => 'investor', 'title' => 'Investor interest inquiry',
        'purpose' => 'Tell BIC about your investment preferences and the strategic contribution you may bring alongside capital.',
        'steps' => [
            $step('Your profile', 'Professional contact information.', [
                $field('name', 'Name', required: true, extra: ['autoComplete'=>'name']),
                $field('organisation', 'Organisation', required: true, extra: ['autoComplete'=>'organization']),
                $field('designation', 'Designation', required: true),
                $field('email', 'Email', 'email', true, ['autoComplete'=>'email']),
                $field('mobile', 'Mobile', 'tel', true, ['autoComplete'=>'tel']),
                $field('linkedIn', 'LinkedIn', 'url'),
                $field('location', 'City or country', required: true),
            ]),
            $step('Investment preferences', 'Broad preferences help establish initial relevance.', [
                $field('investorType', 'Investor type', 'select', true, ['options' => [
                    ['value'=>'individual','label'=>'Individual investor'], ['value'=>'family-office','label'=>'Family office'],
                    ['value'=>'corporate','label'=>'Corporate / strategic'], ['value'=>'fund','label'=>'Fund'], ['value'=>'other','label'=>'Other'],
                ]]),
                $field('preferredSectors', 'Preferred sectors', 'textarea', true),
                $field('preferredStage', 'Preferred stage', required: true),
                $field('ticketSize', 'Preferred ticket-size range', 'select', true, ['options'=>$ranges]),
                $field('strategicCapabilities', 'Strategic capabilities', 'textarea', true, ['hint'=>'For example: market access, governance, category expertise or follow-on network.']),
            ]),
            $step('Declaration and consent', 'Permissions needed to assess potential fit.', $final()),
        ],
    ],
    'ma' => [
        'kind' => 'ma', 'title' => 'M&A advisory inquiry',
        'purpose' => 'Share a concise, non-confidential summary so BIC can understand the transaction context.',
        'steps' => [
            $step('Contact and organisation', 'Who is making the inquiry.', [
                $field('contactName', 'Contact name', required: true, extra: ['autoComplete'=>'name']),
                $field('organisation', 'Organisation', required: true, extra: ['autoComplete'=>'organization']),
                $field('designation', 'Designation', required: true, extra: ['autoComplete'=>'organization-title']),
                $field('email', 'Email', 'email', true, ['autoComplete'=>'email']),
                $field('mobile', 'Mobile', 'tel', true, ['autoComplete'=>'tel']),
            ]),
            $step('Transaction context', 'Use broad ranges and a non-confidential summary.', [
                $field('website', 'Website', 'url'),
                $field('transactionSide', 'Transaction side', 'select', true, ['options' => [
                    ['value'=>'sell-side','label'=>'Sell-side'], ['value'=>'buy-side','label'=>'Buy-side'],
                    ['value'=>'partnership','label'=>'Strategic partnership'], ['value'=>'exploratory','label'=>'Exploratory / discuss'],
                ]]),
                $field('transactionType', 'Transaction type', required: true),
                $field('sector', 'Sector', required: true), $field('geography', 'Geography', required: true),
                $field('transactionRange', 'Approximate transaction range', 'select', true, ['options'=>$ranges]),
                $field('confidentialSummary', 'Brief confidential summary', 'textarea', true, ['hint'=>'Do not include sensitive personal records or full transaction documents.']),
            ]),
            $step('Document and consent', 'Optional context and the permissions needed to review your inquiry.', $final('Optional introductory document')),
        ],
    ],
    'contact' => [
        'kind' => 'contact', 'title' => 'Start a conversation',
        'purpose' => 'Send a general inquiry to Bridge India Capital. Keep the message concise and non-confidential.',
        'steps' => [
            $step('Contact details', 'How BIC can respond.', [
                $field('name', 'Name', required: true, extra: ['autoComplete'=>'name']),
                $field('organisation', 'Organisation', extra: ['autoComplete'=>'organization']),
                $field('email', 'Email', 'email', true, ['autoComplete'=>'email']),
                $field('mobile', 'Mobile', 'tel', true, ['autoComplete'=>'tel']),
            ]),
            $step('Your inquiry', 'Choose the closest category and add a short message.', [
                $field('inquiryCategory', 'Inquiry category', 'select', true, ['options' => [
                    ['value'=>'startup','label'=>'Startup capital'], ['value'=>'msme','label'=>'MSME equity'],
                    ['value'=>'investor','label'=>'Investor interest'], ['value'=>'ma','label'=>'M&A advisory'], ['value'=>'other','label'=>'Other'],
                ]]),
                $field('message', 'Message', 'textarea', true),
            ]),
            $step('Declaration and consent', 'Permissions needed to respond to your inquiry.', $final()),
        ],
    ],
];
