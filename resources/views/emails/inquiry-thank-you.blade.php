<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bridge India Capital</title>
</head>
<body style="margin: 0; padding: 0; background-color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #18181b; line-height: 1.6; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 520px; text-align: left;">
                    
                    <!-- Wordmark -->
                    <tr>
                        <td style="padding-bottom: 28px; border-bottom: 1px solid #eaeaea;">
                            <div style="font-size: 14px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #5B1522;">
                                BRIDGE INDIA CAPITAL
                            </div>
                            <div style="font-size: 11px; letter-spacing: 0.05em; color: #71717a; margin-top: 2px;">
                                Private Investment &amp; Financial Advisory
                            </div>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding-top: 28px; font-size: 14.5px; color: #27272a; line-height: 1.65;">
                            <p style="margin: 0 0 16px 0;">
                                Dear {{ $inquiry->name ?: 'Applicant' }},
                            </p>

                            <p style="margin: 0 0 16px 0;">
                                Thank you for contacting Bridge India Capital. We have received your <strong>{{ $typeName }}</strong> submission.
                            </p>

                            <p style="margin: 0 0 28px 0; padding: 12px 16px; background-color: #fbfbfb; border: 1px solid #f0f0f0; border-radius: 4px; font-size: 13px; color: #52525b;">
                                Reference: <strong style="color: #18181b; font-family: monospace; font-size: 13.5px;">{{ $inquiry->reference }}</strong><br>
                                Date: {{ $formattedDate }}
                                @if($inquiry->company)
                                <br>Company: {{ $inquiry->company }}
                                @endif
                            </p>

                            <p style="margin: 0 0 4px 0; font-weight: 600; color: #18181b;">
                                Bridge India Capital
                            </p>
                            <p style="margin: 0; font-size: 13px; color: #71717a;">
                                <a href="mailto:connect@bridgeindiacapital.com" style="color: #5B1522; text-decoration: none;">connect@bridgeindiacapital.com</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Minimal Footer -->
                    <tr>
                        <td style="padding-top: 36px; border-top: 1px solid #eaeaea; margin-top: 32px; font-size: 11.5px; color: #a1a1aa; line-height: 1.5;">
                            Bridge India Capital &bull; Confidential Advisory Engagements
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
