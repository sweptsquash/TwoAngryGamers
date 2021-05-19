<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
        <base href="/" />
        <link rel="preconnect" href="//www.gstatic.com" />
        <link rel="preconnect" href="//embed.twitch.tv" />
        <link rel="preconnect" href="//platform.twitter.com" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@isset($meta['title']){{ $meta['title'] }} | @endisset{{ config('app.name') }}</title>
        <link rel="canonical" href="{{ URL::current() }}" />
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="msapplication-TileColor" content="#efd798">
        <meta name="theme-color" content="#ffffff">
        <meta name="keywords" content="TAG, Two Angry Gamers, TwoAngryGamersTV, Angry Gamers" />
        <meta name="description" content="Two Angry Gamers are a full time gaming duo providing entertainment to the masses via Twitch and YouTube." />
		<meta name="robots" content="INDEX, FOLLOW" />
		<meta name="author" content="{{ config('app.name') }}" />
        <meta property="fb:pages" content="265951180209853" />
        <meta property="og:site_name" content="{{ config('app.name') }}" />
        <meta property="og:locale" content="en_GB" />
		<meta property="og:title" content="@isset($meta['title']){{ $meta['title'] }} | @endisset{{ config('app.name') }}" />
        <meta property="og:description" content="Two Angry Gamers are a full time gaming duo providing entertainment to the masses via Twitch and YouTube." />
        <meta property="og:url" content="{{ URL::current() }}" />
        <meta property="og:image" content="https://cdn.twoangrygamers.tv/images/social.png" />
        <meta property="og:type" content="website" />
		<meta name="twitter:title" content="@isset($meta['title']){{ $meta['title'] }} | @endisset{{ config('app.name') }}" />
		<meta name="twitter:description" content="Two Angry Gamers are a full time gaming duo providing entertainment to the masses via Twitch and YouTube.">
		<meta name="twitter:image" content="https://cdn.twoangrygamers.tv/images/social.png">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="@2angrygamers" />
        <script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "Organization",
                "name": "Two Angry Gamers",
                "alternateName": "TwoAngryGamers",
                "url": "https://www.twoangrygamers.tv/",
                "logo": "https://cdn.twoangrygamers.tv/images/banner_logo.png",
                "sameAs": [
                    "https://www.youtube.com/user/TwoAngryGamersTV/",
                    "https://www.twitter.com/2angrygamers/",
                    "https://www.facebook.com/TwoAngryGamersTV/",
                    "https://www.twitch.tv/twoangrygamerstv",
                    "https://discord.gg/twoangrygamerstv"
                ]
            }
        </script>
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ mix('/js/manifest.js') }}" defer type="text/javascript"></script>
        <script src="{{ mix('/js/vendor.js') }}" defer type="text/javascript"></script>
        <script src="{{ mix('/js/app.js') }}" defer type="text/javascript"></script>
    </head>

    <body class="h-100">
        @inertia
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-47746245-4', 'auto');
            ga('send', 'pageview');
        </script>
    </body>
</html>
