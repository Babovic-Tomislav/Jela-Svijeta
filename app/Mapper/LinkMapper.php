<?php

namespace App\Mapper;

use Illuminate\Contracts\Pagination\Paginator;
use JsonSerializable;

class LinkMapper implements JsonSerializable
{

    private ?string $previousPage=null;
    private string $selfPage;
    private ?string $nextPage=null;


    public function __construct(Paginator $paginator)
    {
        
        $this->previousPage = str_replace("%2C",",",$paginator->previousPageUrl())?:null;
        $this->selfPage = str_replace("%2C", ",", $paginator->url($paginator->currentPage()));
        $this->nextPage = str_replace("%2C", ",", $paginator->nextPageUrl())?:null;
        
    }

    public function jsonSerialize()
    {
        $output=[
            'prev' => $this->previousPage,
            'next' => $this->nextPage,
            'self' => $this->selfPage
        ];

        return $output;
    }
}
?>