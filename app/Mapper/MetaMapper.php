<?php

namespace App\Mapper;

use Illuminate\Contracts\Pagination\Paginator;
use JsonSerializable;

class MetaMapper implements JsonSerializable
{

    private int $currentPage;
    private int $totalItems;
    private int $itemsPerPage;
    private int $totalPages;

    public function __construct(Paginator $paginator)
    {
        $this->currentPage = $paginator->currentPage();
        $this->totalItems = $paginator->total();
        $this->itemsPerPage = $paginator->perPage();
        $this->totalPages = $paginator->lastPage();
    }

    public function jsonSerialize()
    {
        $output=[
            'currentPage' => $this->currentPage,
            'totalItems' => $this->totalItems,
            'itemsPerPage' => $this->itemsPerPage,
            'totalPages' => $this->totalPages
        ];

        return $output;
    }
}
