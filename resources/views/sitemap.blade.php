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

    <url>
        <loc>{{ route('register') . '?role=0' }}</loc>
    </url>

    <url>
        <loc>{{ route('register') . '?role=1' }}</loc>
    </url>

    @foreach ($blogs as $blog)
        <url>
            <loc>{{ url('/blog/' . $blog->category . '/' . $blog->slug) }}</loc>
            {{-- <lastmod>{{ $blog->updated_at->toAtomString() }}</lastmod> --}}
        </url>
    @endforeach
</urlset>
