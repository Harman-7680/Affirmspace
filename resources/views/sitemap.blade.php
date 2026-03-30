<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @php
        $pages = [
            '/',
            'aboutUs',
            'privacy',
            'refundPolicy',
            'contactWithAdmin',
            'login',
            'register',
            'terms',
            'blogs',
            'community',
            'chat',
            'chatAndDating',
            'counselling',
            'events',
        ];
    @endphp

    @foreach ($pages as $routeName)
        <url>
            <loc>{{ route($routeName) }}</loc>
        </url>
    @endforeach

    @foreach ($blogs as $blog)
        <url>
            <loc>{{ url('/blog/' . $blog->category . '/' . $blog->slug) }}</loc>
            {{-- <lastmod>{{ $blog->updated_at->toAtomString() }}</lastmod> --}}
        </url>
    @endforeach

</urlset>
