<?php

declare(strict_types=1);

namespace App\Utils;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class InputFetcher
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly HttpClientInterface $client,
        #[Autowire('%aoc_cookie%')]
        private readonly string $cookie
    ) {
    }

    public function fetch(int $day, int $year = 2023): string
    {
        return $this->cache->get('input_'.$day, function () use ($day, $year) {
            $response = $this->client->request('GET', "https://adventofcode.com/{$year}/day/{$day}/input", [
                'headers' => [
                    'cookie' => 'session='.$this->cookie,
                ],
            ]);

            return $response->getContent();
        });
    }
}
