<?php

function fetchUrl(string $url): string|false
{
    $headers = [
        'User-Agent: ProxyCollector/1.0',
    ];

    $token = getenv('GITHUB_TOKEN');
    if ($token && str_contains($url, 'raw.githubusercontent.com')) {
        $headers[] = "Authorization: token $token";
    }

    $context = stream_context_create([
        'http' => [
            'header' => implode("\r\n", $headers),
            'timeout' => 30,
            'ignore_errors' => true,
        ],
    ]);

    usleep(rand(200000, 800000));

    $content = @file_get_contents($url, false, $context);

    if ($content === false) {
        return false;
    }

    // Check for HTTP error status
    if (isset($http_response_header)) {
        $status = (int) substr($http_response_header[0], 9, 3);
        if ($status >= 400) {
            echo "⚠️  HTTP $status: $url\n";
            return false;
        }
    }

    return $content;
}

$proxySources = [
    'http' => [
        'https://api.proxyscrape.com/v2/?request=displayproxies&protocol=http&timeout=10000&country=all&ssl=all&anonymity=all',
        'https://raw.githubusercontent.com/BreakingTechFr/Proxy_Free/main/proxies/http.txt',
        'https://raw.githubusercontent.com/ErcinDedeoglu/proxies/main/proxies/http.txt',
        'https://raw.githubusercontent.com/ErcinDedeoglu/proxies/main/proxies/https.txt',
        'https://raw.githubusercontent.com/proxifly/free-proxy-list/main/proxies/protocols/http/data.txt',
        'https://raw.githubusercontent.com/proxifly/free-proxy-list/main/proxies/protocols/https/data.txt',
        'https://raw.githubusercontent.com/vakhov/fresh-proxy-list/master/http.txt',
        'https://raw.githubusercontent.com/vakhov/fresh-proxy-list/master/https.txt',
        'https://sunny9577.github.io/proxy-scraper/generated/http_proxies.txt',
        'https://raw.githubusercontent.com/TheSpeedX/SOCKS-List/master/http.txt',
        // new
        'https://raw.githubusercontent.com/monosans/proxy-list/main/proxies/http.txt',
        'https://raw.githubusercontent.com/roosterkid/openproxylist/main/HTTPS_RAW.txt',
        'https://raw.githubusercontent.com/mmpx12/proxy-list/master/http.txt',
        'https://raw.githubusercontent.com/TheSpeedX/PROXY-List/master/http.txt',
        'https://raw.githubusercontent.com/fyvri/fresh-proxy-list/archive/storage/classic/http.txt',
        'https://raw.githubusercontent.com/dpangestuw/Free-Proxy/refs/heads/main/http_proxies.txt',
        'https://raw.githubusercontent.com/iplocate/free-proxy-list/main/protocols/http.txt',
        'https://raw.githubusercontent.com/ClearProxy/checked-proxy-list/main/http/raw/all.txt',
        'https://cdn.jsdelivr.net/gh/databay-labs/free-proxy-list/http.txt',
        'https://raw.githubusercontent.com/ProxyScraper/ProxyScraper/main/http.txt',
        'https://raw.githubusercontent.com/Skillter/ProxyGather/refs/heads/master/proxies/working-proxies-http.txt',
        'https://raw.githubusercontent.com/vmheaven/VMHeaven-Free-Proxy-Updated/refs/heads/main/http.txt',
        'https://raw.githubusercontent.com/wiki/gfpcom/free-proxy-list/lists/http.txt', // not good
        // new 2
        'https://raw.githubusercontent.com/zloi-user/hideip.me/main/http.txt',
        'https://raw.githubusercontent.com/zloi-user/hideip.me/main/https.txt',
        'https://raw.githubusercontent.com/MuRongPIG/Proxy-Master/main/http.txt',
        // new 3 — discovered repos (starred, actively updated)
        'https://raw.githubusercontent.com/r00tee/Proxy-List/main/Https.txt',
        'https://raw.githubusercontent.com/Zaeem20/FREE_PROXIES_LIST/master/http.txt',
        'https://raw.githubusercontent.com/Mohammedcha/ProxRipper/main/full_proxies/http.txt',
        'https://raw.githubusercontent.com/Vann-Dev/proxy-list/main/proxies/http.txt',
        'https://raw.githubusercontent.com/Argh94/Proxy-List/main/HTTP.txt',
        'https://raw.githubusercontent.com/clarketm/proxy-list/master/proxy-list-raw.txt',
        'https://raw.githubusercontent.com/SevenworksDev/proxy-list/main/proxies/http.txt',
        // new 4 — discovered repos (verified active, auto-updating)
        'https://raw.githubusercontent.com/openproxyhub/proxy-exports/main/http_connect.txt',
        'https://raw.githubusercontent.com/proxygenerator1/ProxyGenerator/main/ALL/http.txt',
        'https://raw.githubusercontent.com/naravid19/checked-proxies/main/proxies/http.txt',
        'https://raw.githubusercontent.com/Thordata/awesome-free-proxy-list/main/proxies/http.txt',
        'https://raw.githubusercontent.com/VPSLabCloud/VPSLab-Free-Proxy-List/main/http_all.txt',
    ],
    'socks4' => [
        'https://api.proxyscrape.com/v2/?request=displayproxies&protocol=socks4&timeout=10000&country=all&ssl=all&anonymity=all',
        'https://raw.githubusercontent.com/BreakingTechFr/Proxy_Free/main/proxies/socks4.txt',
        'https://raw.githubusercontent.com/ErcinDedeoglu/proxies/main/proxies/socks4.txt',
        'https://raw.githubusercontent.com/proxifly/free-proxy-list/main/proxies/protocols/socks4/data.txt',
        'https://raw.githubusercontent.com/vakhov/fresh-proxy-list/master/socks4.txt',
        'https://sunny9577.github.io/proxy-scraper/generated/socks4_proxies.txt',
        'https://raw.githubusercontent.com/TheSpeedX/SOCKS-List/master/socks4.txt',
        // new
        'https://raw.githubusercontent.com/monosans/proxy-list/main/proxies/socks4.txt',
        'https://raw.githubusercontent.com/roosterkid/openproxylist/main/SOCKS4_RAW.txt',
        'https://raw.githubusercontent.com/mmpx12/proxy-list/master/socks4.txt',
        'https://raw.githubusercontent.com/TheSpeedX/PROXY-List/master/socks4.txt',
        'https://raw.githubusercontent.com/fyvri/fresh-proxy-list/archive/storage/classic/socks4.txt',
        'https://raw.githubusercontent.com/dpangestuw/Free-Proxy/refs/heads/main/socks4_proxies.txt',
        'https://raw.githubusercontent.com/iplocate/free-proxy-list/main/protocols/socks4.txt',
        'https://raw.githubusercontent.com/ClearProxy/checked-proxy-list/main/socks4/raw/all.txt',
        'https://raw.githubusercontent.com/ProxyScraper/ProxyScraper/main/socks4.txt',
        'https://raw.githubusercontent.com/Skillter/ProxyGather/refs/heads/master/proxies/working-proxies-socks4.txt',
        'https://raw.githubusercontent.com/vmheaven/VMHeaven-Free-Proxy-Updated/refs/heads/main/socks4.txt',
        'https://raw.githubusercontent.com/wiki/gfpcom/free-proxy-list/lists/socks4.txt', // not good
        // new 2
        'https://raw.githubusercontent.com/zloi-user/hideip.me/main/socks4.txt',
        'https://raw.githubusercontent.com/MuRongPIG/Proxy-Master/main/socks4.txt',
        // new 3 — discovered repos (starred, actively updated)
        'https://raw.githubusercontent.com/r00tee/Proxy-List/main/Socks4.txt',
        'https://raw.githubusercontent.com/Zaeem20/FREE_PROXIES_LIST/master/socks4.txt',
        'https://raw.githubusercontent.com/Mohammedcha/ProxRipper/main/full_proxies/socks4.txt',
        'https://raw.githubusercontent.com/Vann-Dev/proxy-list/main/proxies/socks4.txt',
        'https://raw.githubusercontent.com/Argh94/Proxy-List/main/SOCKS4.txt',
        'https://raw.githubusercontent.com/SevenworksDev/proxy-list/main/proxies/socks4.txt',
        // new 4 — discovered repos (verified active, auto-updating)
        'https://raw.githubusercontent.com/openproxyhub/proxy-exports/main/socks4.txt',
        'https://raw.githubusercontent.com/proxygenerator1/ProxyGenerator/main/ALL/socks4.txt',
        'https://raw.githubusercontent.com/naravid19/checked-proxies/main/proxies/socks4.txt',
        'https://raw.githubusercontent.com/Thordata/awesome-free-proxy-list/main/proxies/socks4.txt',
        'https://raw.githubusercontent.com/VPSLabCloud/VPSLab-Free-Proxy-List/main/socks4_all.txt',
    ],
    'socks5' => [
        'https://raw.githubusercontent.com/hookzof/socks5_list/master/proxy.txt',
        'https://raw.githubusercontent.com/BreakingTechFr/Proxy_Free/main/proxies/socks5.txt',
        'https://raw.githubusercontent.com/ErcinDedeoglu/proxies/main/proxies/socks5.txt',
        'https://raw.githubusercontent.com/proxifly/free-proxy-list/main/proxies/protocols/socks5/data.txt',
        'https://raw.githubusercontent.com/vakhov/fresh-proxy-list/master/socks5.txt',
        'https://sunny9577.github.io/proxy-scraper/generated/socks5_proxies.txt',
        'https://raw.githubusercontent.com/TheSpeedX/SOCKS-List/master/socks5.txt',
        // new
        'https://raw.githubusercontent.com/monosans/proxy-list/main/proxies/socks5.txt',
        'https://raw.githubusercontent.com/roosterkid/openproxylist/main/SOCKS5_RAW.txt',
        'https://raw.githubusercontent.com/mmpx12/proxy-list/master/socks5.txt',
        'https://raw.githubusercontent.com/TheSpeedX/PROXY-List/master/socks5.txt',
        'https://raw.githubusercontent.com/fyvri/fresh-proxy-list/archive/storage/classic/socks5.txt',
        'https://raw.githubusercontent.com/dpangestuw/Free-Proxy/refs/heads/main/socks5_proxies.txt',
        'https://raw.githubusercontent.com/iplocate/free-proxy-list/main/protocols/socks5.txt',
        'https://raw.githubusercontent.com/ClearProxy/checked-proxy-list/main/socks5/raw/all.txt',
        'https://cdn.jsdelivr.net/gh/databay-labs/free-proxy-list/socks5.txt',
        'https://raw.githubusercontent.com/ProxyScraper/ProxyScraper/main/socks5.txt',
        'https://raw.githubusercontent.com/Skillter/ProxyGather/refs/heads/master/proxies/working-proxies-socks5.txt',
        'https://raw.githubusercontent.com/vmheaven/VMHeaven-Free-Proxy-Updated/refs/heads/main/socks5.txt',
        'https://raw.githubusercontent.com/wiki/gfpcom/free-proxy-list/lists/socks5.txt', // not good
        // new 2
        'https://raw.githubusercontent.com/zloi-user/hideip.me/main/socks5.txt',
        'https://raw.githubusercontent.com/MuRongPIG/Proxy-Master/main/socks5.txt',
        // new 3 — discovered repos (starred, actively updated)
        'https://raw.githubusercontent.com/r00tee/Proxy-List/main/Socks5.txt',
        'https://raw.githubusercontent.com/Zaeem20/FREE_PROXIES_LIST/master/socks5.txt',
        'https://raw.githubusercontent.com/Mohammedcha/ProxRipper/main/full_proxies/socks5.txt',
        'https://raw.githubusercontent.com/Vann-Dev/proxy-list/main/proxies/socks5.txt',
        'https://raw.githubusercontent.com/Argh94/Proxy-List/main/SOCKS5.txt',
        // new 4 — discovered repos (verified active, auto-updating)
        'https://raw.githubusercontent.com/openproxyhub/proxy-exports/main/socks5.txt',
        'https://raw.githubusercontent.com/proxygenerator1/ProxyGenerator/main/ALL/socks5.txt',
        'https://raw.githubusercontent.com/naravid19/checked-proxies/main/proxies/socks5.txt',
        'https://raw.githubusercontent.com/Thordata/awesome-free-proxy-list/main/proxies/socks5.txt',
        'https://raw.githubusercontent.com/VPSLabCloud/VPSLab-Free-Proxy-List/main/socks5_all.txt',
    ]
];


function normalizeProxyLine(string $line, string $type): ?string
{
    $line = trim($line);
    $line = preg_replace('#^(http|https|socks4|socks5)://#i', '', $line);
    if (preg_match('/^([\d\.]+):(\d+)/', $line, $matches)) {
        return "($type){$matches[1]}:{$matches[2]}";
    }
    return null;
}

// Remove old output files before generating new ones
foreach (glob('all*.txt') as $oldFile) {
    unlink($oldFile);
    echo "🗑️  Removed old file: $oldFile\n";
}

$allProxies = [];

foreach ($proxySources as $type => $urls) {
    $proxies = [];
    $urlCount = 0;
    $scraperCount = 0;

    echo "\n==== Processing type: $type ====\n";

    foreach ($urls as $url) {
        echo "Downloading: $url\n";
        $content = fetchUrl($url);
        if (!$content) {
            echo "❌ Failed: $url\n";
            continue;
        }

        foreach (explode("\n", $content) as $line) {
            $proxy = normalizeProxyLine($line, $type);
            if ($proxy) {
                $proxies[] = $proxy;
                $urlCount++;
            }
        }
    }

    echo "Running proxy_scraper -p $type\n";
    exec("proxy_scraper -p $type");

    if (file_exists("output.txt")) {
        foreach (file("output.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $proxy = normalizeProxyLine($line, $type);
            if ($proxy) {
                $proxies[] = $proxy;
                $scraperCount++;
            }
        }
        unlink("output.txt");
    }

    $totalBeforeDedup = count($proxies);
    $uniqueProxies = array_unique($proxies);
    $totalSaved = count($uniqueProxies);
    $duplicates = $totalBeforeDedup - $totalSaved;

    $allProxies = array_merge($allProxies, $uniqueProxies);

    echo "✅ Done: $type\n";
    echo "   - From URLs         : $urlCount\n";
    echo "   - From proxy_scraper: $scraperCount\n";
    echo "   - Total collected   : $totalBeforeDedup\n";
    echo "   - Duplicates removed: $duplicates\n";
    echo "   - Total saved       : $totalSaved\n";
}

// Save all proxies split by 300,000 rows
$allUnique = array_unique($allProxies);
$totalCount = count($allUnique);
$chunkSize = 300000;

$chunks = array_chunk($allUnique, $chunkSize);

foreach ($chunks as $index => $chunk) {
    $filename = $index === 0 ? 'all.txt' : "all_part" . ($index + 1) . ".txt";
    file_put_contents($filename, implode(PHP_EOL, $chunk));
    echo "📦 Saved $filename with " . count($chunk) . " proxies.\n";
}

echo "\n✅ Total unique proxies saved: $totalCount\n";
