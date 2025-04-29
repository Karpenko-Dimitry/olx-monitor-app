<?php

namespace App\Services\ParseService;

use App\Services\RequestService\RequestService;

class ParseService
{
    protected RequestService $requestService;
    public function __construct()
    {
        $this->requestService = resolve('request_service');
    }

    /**
     * @param string $url
     * @return float|null
     */
    public function parsePrice(string $url): ?float
    {
        try {
            $request = $this->requestService->setLink($url)->execute();
            $html = $request?->getBody()->getContents();

            if ($html) {
                $dom = str_get_html($html);
                foreach($dom->find('div') as $element) {
                    if (($element->attr['data-testid'] ?? null) === 'ad-price-container') {
                        foreach ($element->children() as $child) {
                            if ($child->tag === 'h3') {
                                return (float) preg_replace(['/^\D*/', '/ /', '/,/'], ['', '', '.'], $child->innertext ?? 0);
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }

}
