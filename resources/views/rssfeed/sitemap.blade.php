@php
echo '<?xml version="1.0" encoding="UTF-8"?>
  <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
  <loc>'.url('daily-sitemap/sitemap-section.xml').'</loc>
  </sitemap>
  ';
for ($i = 0; $i < 365; $i++) {
  echo '<sitemap>
        <loc>'.url('daily-sitemap/'.date('Y-m-d', strtotime("-$i day")).'/sitemap.xml').'</loc>
      </sitemap>';
}
echo '</sitemapindex>';                            
@endphp