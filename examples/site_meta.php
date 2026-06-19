<?php

/**
 * Site meta information container for "华体会" related content.
 *
 * Provides structured metadata and a method to generate a concise description.
 */
class SiteMeta
{
    /**
     * @var array<string, mixed> The internal metadata storage.
     */
    private array $data;

    /**
     * @param string $url       The site's base URL.
     * @param string $keyword   A primary keyword for the site.
     * @param string $title     A short title.
     * @param int    $version   A version number for the meta structure.
     */
    public function __construct(
        string $url = 'https://home-m-hth.com.cn',
        string $keyword = '华体会',
        string $title = 'Home Meta Hub',
        int $version = 202503
    ) {
        $this->data = [
            'url'         => $url,
            'keyword'     => $keyword,
            'title'       => $title,
            'version'     => $version,
            'description' => '',
            'tags'        => [],
            'author'      => 'Meta Generator',
            'created'     => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * Set a custom description.
     *
     * @param string $desc The description text.
     * @return void
     */
    public function setDescription(string $desc): void
    {
        $this->data['description'] = $desc;
    }

    /**
     * Add one or more tags to the metadata.
     *
     * @param string ...$tags Tags to add.
     * @return void
     */
    public function addTags(string ...$tags): void
    {
        foreach ($tags as $tag) {
            $cleanTag = trim(strip_tags($tag));
            if ($cleanTag !== '') {
                $this->data['tags'][] = $cleanTag;
            }
        }
        $this->data['tags'] = array_unique($this->data['tags']);
    }

    /**
     * Generate a short, HTML-safe description text using the stored metadata.
     *
     * The description is assembled from the keyword, URL, title, and any tags.
     * It will be at most 200 characters long.
     *
     * @return string The generated description (HTML-escaped).
     */
    public function generateDescription(): string
    {
        $keyword = htmlspecialchars($this->data['keyword'], ENT_QUOTES, 'UTF-8');
        $url     = htmlspecialchars($this->data['url'], ENT_QUOTES, 'UTF-8');
        $title   = htmlspecialchars($this->data['title'], ENT_QUOTES, 'UTF-8');

        $parts = [
            "关键词: {$keyword}",
            "站点: {$title}",
            "地址: {$url}",
        ];

        if (!empty($this->data['tags'])) {
            $tagList = array_map(function ($tag) {
                return htmlspecialchars($tag, ENT_QUOTES, 'UTF-8');
            }, $this->data['tags']);
            $parts[] = '标签: ' . implode(', ', array_slice($tagList, 0, 5));
        }

        $raw = implode(' | ', $parts);

        // Truncate to max 200 characters, ensuring we don't break in the middle of a multi-byte char.
        if (mb_strlen($raw) > 200) {
            $raw = mb_substr($raw, 0, 197) . '...';
        }

        return $raw;
    }

    /**
     * Get a specific metadata field.
     *
     * @param string $key The field name.
     * @return mixed|null The value, or null if not set.
     */
    public function get(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Return the entire metadata array.
     *
     * @return array<string, mixed>
     */
    public function getAll(): array
    {
        return $this->data;
    }
}

// --- Example usage (not executed when included) ---
$meta = new SiteMeta();
$meta->addTags('体育', '娱乐', '华体会', '电竞');
$meta->setDescription('Official meta for 华体会 platform.');

echo $meta->generateDescription() . "\n";

// Demonstrate direct access to fields
echo 'URL: ' . $meta->get('url') . "\n";
echo 'Keyword: ' . $meta->get('keyword') . "\n";