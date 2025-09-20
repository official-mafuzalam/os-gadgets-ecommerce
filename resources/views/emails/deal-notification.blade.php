<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Special Deal: {{ $deal->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9fafb;
        }

        .email-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: {{ $deal->background_color ?: '#4f46e5' }};
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 25px;
        }

        .deal-highlight {
            background: #f8fafc;
            border-left: 4px solid {{ $deal->background_color ?: '#4f46e5' }};
            padding: 15px;
            margin: 20px 0;
        }

        .discount-container {
            display: flex;
            align-items: center;
            margin: 20px 0;
            flex-wrap: wrap;
            gap: 15px;
        }

        .discount-badge {
            background: {{ $deal->background_color ?: '#4f46e5' }};
            color: white;
            border-radius: 6px;
            padding: 10px 15px;
            font-weight: bold;
            text-align: center;
            min-width: 80px;
        }

        .discount-text {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
        }

        .deal-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
            display: block;
            max-width: 100%;
        }

        .image-placeholder {
            background: #f3f4f6;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            margin: 20px 0;
            color: #6b7280;
        }

        .button {
            display: inline-block;
            background: {{ $deal->background_color ?: '#4f46e5' }};
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
        }

        .validity {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            text-align: center;
        }

        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .discount-container {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>Special Offer Just For You!</h1>
        </div>

        <div class="content">
            <h2>{{ $deal->title }}</h2>

            <div class="deal-highlight">
                <p>{{ $deal->description }}</p>
            </div>

            @if ($deal->discount_text)
                <div class="discount-text">
                    {{ $deal->discount_text }}
                </div>
            @endif

            <div class="discount-container">
                @if ($deal->discount_percentage)
                    <div class="discount-badge">
                        {{ $deal->discount_percentage }}% OFF
                    </div>
                @endif

                @if ($deal->discount_details)
                    <div>
                        {{ $deal->discount_details }}
                    </div>
                @endif
            </div>

            @if ($deal->image_url && filter_var($deal->image_url, FILTER_VALIDATE_URL))
                <img src="{{ $deal->image_url }}" alt="{{ $deal->title }}" class="deal-image" width="560"
                    height="300">
            @else
                <div class="image-placeholder">
                    <p>🔥 Exclusive Deal Inside!</p>
                    <p>Enable images to view this special offer</p>
                </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ $deal->button_link }}" class="button">
                    {{ $deal->button_text ?: 'Claim This Deal' }}
                </a>
            </div>

            <div class="validity">
                <strong>⏰ Limited Time Offer!</strong><br>
                @if ($deal->starts_at)
                    Starts: {{ $deal->starts_at->format('F j, Y') }}<br>
                @endif
                @if ($deal->ends_at)
                    Ends: {{ $deal->ends_at->format('F j, Y \a\t g:i A') }}
                @endif
            </div>

            <p>Don't miss out on this exclusive offer created just for our valued subscribers!</p>
        </div>

        <div class="footer">
            <p>Best regards,<br>
                The {{ config('app.name') }} Team</p>

            <p style="margin-top: 15px; font-size: 12px;">
                You received this email because you subscribed to our newsletter.<br>
                <a href="{{ url('/unsubscribe') }}" style="color: #6b7280;">Unsubscribe</a>
                if you no longer wish to receive these offers.
            </p>
        </div>
    </div>
</body>

</html>