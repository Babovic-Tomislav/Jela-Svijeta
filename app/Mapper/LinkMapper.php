<?php

namespace App\Mapper;

use Illuminate\Contracts\Pagination\Paginator;
use JsonSerializable;

class LinkMapper implements JsonSerializable
{
    private ?string $previousPage;
    private string $selfPage;
    private ?string $nextPage;


    public function __construct(Paginator $paginator)
    {
        $this->previousPage = str_replace(
            "%2C",
            ",",
            $paginator->previousPageUrl()
        ) ?: null;
        $this->selfPage = str_replace(
            "%2C",
            ",",
            $paginator->url($paginator->currentPage())
        );
        $this->nextPage = str_replace(
            "%2C",
            ",",
            $paginator->nextPageUrl()
        ) ?: null;
    }

    public function jsonSerialize()
    {
        return [
            'prev' => $this->previousPage,
            'next' => $this->nextPage,
            'self' => $this->selfPage
        ];
    }
}
