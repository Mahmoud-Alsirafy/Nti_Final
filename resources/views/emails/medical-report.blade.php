<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Report</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f4; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1f2b23;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f4; padding: 30px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.05); border: 1px solid #e5e9e4;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #2f7d47; padding: 24px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px;">PetCare</h1>
                            <p style="color: #d1fae5; margin: 4px 0 0; font-size: 13px;">Official Veterinary Medical Report</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 16px; margin: 0 0 16px;">Hello <strong>{{ $pet->owner->name ?? 'Pet Owner' }}</strong>,</p>
                            <p style="font-size: 14px; color: #4b5563; line-height: 1.6; margin: 0 0 24px;">
                                A new medical report has been logged for your pet <strong>{{ $pet->name }}</strong> by <strong>Dr. {{ $doctor->name }}</strong>.
                            </p>

                            <!-- Pet Summary Box -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8faf8; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <table role="presentation" width="100%">
                                            <tr>
                                                <td style="font-size: 13px; color: #64748b;">Patient:</td>
                                                <td style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ $pet->name }} ({{ $pet->type ?? 'Pet' }})</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px; color: #64748b;">Visit Date:</td>
                                                <td style="font-size: 14px; font-weight: 600; color: #1e293b;">{{ $visitDate }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 13px; color: #64748b;">Attending Doctor:</td>
                                                <td style="font-size: 14px; font-weight: 600; color: #1e293b;">Dr. {{ $doctor->name }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Findings -->
                            <div style="margin-bottom: 20px;">
                                <h3 style="margin: 0 0 8px; font-size: 14px; color: #2f7d47; text-transform: uppercase; letter-spacing: 0.5px;">Diagnosis &amp; Primary Notes</h3>
                                <div style="background-color: #ffffff; border-left: 3px solid #2f7d47; padding: 12px 16px; background-color: #f0fdf4; border-radius: 0 8px 8px 0; font-size: 14px; line-height: 1.6; color: #1f2937;">
                                    {{ $diagnosis }}
                                </div>
                            </div>

                            @if (!empty($treatment))
                                <div style="margin-bottom: 24px;">
                                    <h3 style="margin: 0 0 8px; font-size: 14px; color: #2f7d47; text-transform: uppercase; letter-spacing: 0.5px;">Treatment Plan &amp; Recommendations</h3>
                                    <div style="background-color: #ffffff; border-left: 3px solid #3b82f6; padding: 12px 16px; background-color: #eff6ff; border-radius: 0 8px 8px 0; font-size: 14px; line-height: 1.6; color: #1f2937;">
                                        {{ $treatment }}
                                    </div>
                                </div>
                            @endif

                            <!-- CTA Button -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 30px 0 10px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('medical_history', $pet->id) }}" style="display: inline-block; background-color: #2f7d47; color: #ffffff; text-decoration: none; padding: 13px 28px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                                            View Full Medical History &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8faf8; padding: 18px 30px; text-align: center; border-top: 1px solid #eef1ec; font-size: 12px; color: #64748b;">
                            PetCare Management Platform &bull; Keep your pets healthy and happy.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
