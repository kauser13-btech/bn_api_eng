<?php

/**
 * সোশ্যাল মিডিয়া ভিডিও এমবেডার
 * যে কোন YouTube, Facebook, Twitter (X), Instagram ভিডিও URL থেকে এমবেড কোড তৈরি করা
 */

class SocialMediaEmbedder
{
    /**
     * ভিডিও URL থেকে এমবেড কোড তৈরি করে
     * 
     * @param string $url সোশ্যাল মিডিয়া ভিডিও লিংক
     * @param int $width iframe এর প্রস্থ
     * @param int $height iframe এর উচ্চতা
     * @return array ['platform' => প্লাটফর্ম নাম, 'id' => ভিডিও আইডি, 'embed_code' => এমবেড কোড, 'status' => সফল কিনা]
     */
    public function getEmbedFromUrl($url)
    {
        $url = trim($url);

        // URL পরীক্ষা
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->errorResponse('অবৈধ URL');
        }

        // YouTube চেক
        if (stripos($url, 'youtube.com') !== false || stripos($url, 'youtu.be') !== false) {
            return $this->getYouTubeEmbed($url, 560, 315);
        }

        // Facebook চেক
        elseif (stripos($url, 'facebook.com') !== false || stripos($url, 'fb.com') !== false) {
            return $this->getFacebookEmbed($url, 560, 315);
        }

        // Twitter/X চেক
        elseif (stripos($url, 'twitter.com') !== false || stripos($url, 'x.com') !== false) {
            return $this->getTwitterEmbed($url, 560, 600);
        }

        // Instagram চেক
        elseif (stripos($url, 'instagram.com') !== false) {
            return $this->getInstagramEmbed($url, 560, 600);
        }

        // সমর্থিত প্লাটফর্ম নয়
        return $this->errorResponse('এই URL সমর্থিত নয়। শুধু YouTube, Facebook, Twitter/X, Instagram সমর্থিত।');
    }

    /**
     * YouTube ভিডিও এমবেড কোড তৈরি করা
     */
    private function getYouTubeEmbed($url, $width, $height)
    {
        $videoId = $this->extractYouTubeId($url);

        if (!$videoId) {
            return $this->errorResponse('YouTube ভিডিও আইডি পাওয়া যায়নি');
        }

        $embedCode = '<div class="ratio ratio-16x9 mb-4 socialMediaEmbedder" style="min-height: ' . $height . 'px;"><iframe width="' . $width . '" height="' . $height . '" ' .
            'src="https://www.youtube.com/embed/' . $videoId . '?rel=0&autoplay=1&mute=1" ' .
            'frameborder="0" allow="accelerometer; autoplay; clipboard-write; ' .
            'encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen>' .
            '</iframe></div><p>&nbsp;</p>';

        return [
            'platform' => 'YouTube',
            'id' => $videoId,
            'embed_code' => $embedCode,
            'status' => 'success'
        ];
    }

    /**
     * Facebook ভিডিও এমবেড কোড তৈরি করা
     */
    private function getFacebookEmbed($url, $width, $height)
    {
        $videoId = $this->extractFacebookVideoId($url);

        if (!$videoId) {
            return $this->errorResponse('Facebook ভিডিও আইডি পাওয়া যায়নি');
        }

        $encodedUrl = urlencode("https://www.facebook.com/watch/?v={$videoId}");

        $embedCode = '<div class="ratio ratio-16x9 mb-4 socialMediaEmbedder" style="min-height: ' . $height . 'px;"><iframe src="https://www.facebook.com/plugins/video.php?height=' . $height .
            '&href=' . $encodedUrl .
            '&show_text=false' .
            '&width=' . $width . '&t=0" ' .
            'width="' . $width . '" ' .
            'height="' . $height . '" ' .
            'style="border:none;overflow:hidden" ' .
            'scrolling="no" frameborder="0" ' .
            'allowfullscreen="true" ' .
            'allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">' .
            '</iframe></div><p>&nbsp;</p>';

        return [
            'platform' => 'Facebook',
            'id' => $videoId,
            'embed_code' => $embedCode,
            'status' => 'success'
        ];
    }

    /**
     * Twitter/X এমবেড কোড তৈরি করা
     */
    private function getTwitterEmbed($url, $width, $height)
    {
        $tweetId = $this->extractTwitterId($url);

        if (!$tweetId) {
            return $this->errorResponse('Twitter/X পোস্ট আইডি পাওয়া যায়নি');
        }

        // Twitter/X iframe এমবেড
        $embedCode = '<div class="ratio ratio-16x9 mb-4 socialMediaEmbedder" style="height: ' . $height . 'px;"><iframe scrolling="yes" id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ' .
            'class="twitter-tweet twitter-tweet-rendered" ' .
            'style="display: block; width: ' . $width . 'px; height: ' . $height . 'px; margin: 0 auto;"' .
            'src="https://platform.twitter.com/embed/Tweet.html?id=' . $tweetId . '">' .
            '</iframe>' .
            '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div><p>&nbsp;</p>';

        return [
            'platform' => 'Twitter/X',
            'id' => $tweetId,
            'embed_code' => $embedCode,
            'status' => 'success'
        ];
    }

    /**
     * Instagram এমবেড কোড তৈরি করা
     */
    private function getInstagramEmbed($url, $width, $height)
    {
        $postId = $this->extractInstagramId($url);

        if (!$postId) {
            return $this->errorResponse('Instagram পোস্ট আইডি পাওয়া যায়নি');
        }

        // Instagram এমবেড কোড
        $embedCode = '<div class="ratio ratio-16x9 mb-4 socialMediaEmbedder" style="height: ' . $height . 'px;"><iframe scrolling="yes" src="https://www.instagram.com/p/' . $postId . '/embed/" ' .
            'width="' . $width . '" height="' . $height . '" ' .
            'frameborder="0" scrolling="no" allowtransparency="true">' .
            '</iframe>' .
            '<script async src="//www.instagram.com/embed.js"></script></div><p>&nbsp;</p>';

        return [
            'platform' => 'Instagram',
            'id' => $postId,
            'embed_code' => $embedCode,
            'status' => 'success'
        ];
    }

    /**
     * YouTube ভিডিও আইডি বের করা
     */
    private function extractYouTubeId($url)
    {
        $patterns = [
            // youtu.be/VIDEO_ID
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',
            // youtube.com/watch?v=VIDEO_ID
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            // youtube.com/embed/VIDEO_ID
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',
            // youtube.com/v/VIDEO_ID
            '/youtube\.com\/v\/([a-zA-Z0-9_-]+)/',
            // youtube.com/shorts/VIDEO_ID
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        // YouTube URL থেকে query parameters পার্স করা
        $queryString = parse_url($url, PHP_URL_QUERY);
        if ($queryString) {
            parse_str($queryString, $params);
            if (isset($params['v'])) {
                return $params['v'];
            }
        }

        return false;
    }

    /**
     * Facebook ভিডিও আইডি বের করা
     */
    private function extractFacebookVideoId($url)
    {
        // বিভিন্ন ধরনের ফেসবুক URL প্যাটার্ন ম্যাচ করা
        $patterns = [
            // watch?v= ফরম্যাট
            '/facebook\.com\/watch\?v=(\d+)/i',
            '/facebook\.com\/watch\/\?v=(\d+)/i',
            '/fb\.com\/watch\?v=(\d+)/i',
            '/fb\.com\/watch\/\?v=(\d+)/i',
            '/facebook\.com\/[^\/]+\/videos\/(\d+)/i',
            '/fb\.com\/[^\/]+\/videos\/(\d+)/i',

            // web.facebook.com ফরম্যাট
            '/web\.facebook\.com\/watch\?v=(\d+)/i',
            '/web\.facebook\.com\/watch\/\?v=(\d+)/i',

            // m.facebook.com (মোবাইল) ফরম্যাট
            '/m\.facebook\.com\/watch\?v=(\d+)/i',
            '/m\.facebook\.com\/[^\/]+\/videos\/(\d+)/i',

            // রিল ID
            '/facebook\.com\/reel\/(\d+)/i',
            '/fb\.com\/reel\/(\d+)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return end($matches);
            }
        }

        // অন্যান্য ফরম্যাট - query parameters চেক
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            if (isset($queryParams['v'])) {
                return $queryParams['v'];
            }
        }

        return false;
    }

    /**
     * Twitter/X টুইট আইডি বের করা
     */
    private function extractTwitterId($url)
    {
        // প্যাটার্ন: twitter.com/anyuser/status/12345 বা x.com/anyuser/status/12345
        if (preg_match('/(?:twitter|x)\.com\/(?:#!\/)?(?:\w+)\/status(?:es)?\/(\d+)/i', $url, $matches)) {
            return $matches[1];
        }

        return false;
    }

    /**
     * Instagram পোস্ট আইডি বের করা
     */
    private function extractInstagramId($url)
    {
        // প্যাটার্ন: instagram.com/p/CODE/ বা instagram.com/reel/CODE/
        if (preg_match('/instagram\.com\/(?:p|reel)\/([a-zA-Z0-9_-]+)/i', $url, $matches)) {
            return $matches[1];
        }

        return false;
    }

    /**
     * ত্রুটি রেসপন্স
     */
    private function errorResponse($message)
    {
        return [
            'platform' => 'unknown',
            'id' => null,
            'embed_code' => null,
            'error' => $message,
            'status' => 'error'
        ];
    }
}

$videoUrl = $_GET['url'];
if (isset($videoUrl)) {
    $embedder = new SocialMediaEmbedder();
    $result = $embedder->getEmbedFromUrl($videoUrl);
    echo $result['embed_code'];
    // echo htmlspecialchars($result['embed_code']);
} else {
    echo '';
}
