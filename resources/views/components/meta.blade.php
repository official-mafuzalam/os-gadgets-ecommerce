<!-- =====================
     SEO & Meta Tags
    ===================== -->
<meta name="description" content="{{ setting('meta_description', 'Best E-commerce website') }}">
<meta name="keywords" content="{{ setting('meta_keywords', 'software, solutions, it') }}">
<meta name="author" content="{{ setting('meta_author', setting('site_name', 'Octosync Software Ltd')) }}">
<meta name="language" content="{{ setting('meta_language', 'en') }}">

<!-- =====================
     Open Graph Tags
    ===================== -->
<meta property="og:title" content="{{ setting('og_title', setting('site_name', 'Octosync Software Ltd')) }}">
<meta property="og:description"
    content="{{ setting('og_description', setting('meta_description', 'Best E-commerce website')) }}">
<meta property="og:image" content="{{ setting('og_image', asset('default-og.png')) }}">
<meta property="og:url" content="{{ setting('og_url', url()->current()) }}">
<meta property="og:type" content="{{ setting('og_type', 'website') }}">
<meta property="fb:app_id" content="{{ setting('fb_app_id') }}">

<!-- =====================
     Twitter Card Tags
    ===================== -->
<meta name="twitter:card" content="{{ setting('twitter_card', 'summary_large_image') }}">
<meta name="twitter:title" content="{{ setting('twitter_title', setting('site_name', 'Octosync Software Ltd')) }}">
<meta name="twitter:description"
    content="{{ setting('twitter_description', setting('meta_description', 'Best E-commerce website')) }}">
<meta name="twitter:image" content="{{ setting('twitter_image', asset('default-twitter.png')) }}">
