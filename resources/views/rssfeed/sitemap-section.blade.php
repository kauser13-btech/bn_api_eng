@php echo '<?xml version="1.0" encoding="UTF-8"?>
     <urlset xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>'.url('/').'</loc>
        <changefreq>hourly</changefreq>
    </url>';
    foreach ($urlslist as $url) {
        echo '<url>
              <loc>'.url('category/'.$url->slug).'</loc>
              <changefreq>hourly</changefreq>
          </url>';
    }
echo '</urlset>';
@endphp