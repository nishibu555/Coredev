<?php
namespace App\Services\SuggestionEngine;

use App\Services\SuggestionEngine\SuggestionRequest;

class SuggestionEngine
{
    public $suggestionRequest;

    public function __construct(SuggestionRequest $suggestionRequest)
    {
        $this->suggestionRequest = $suggestionRequest;
    }

    public function getKeywordsByTimeline()
    {

    }
}

