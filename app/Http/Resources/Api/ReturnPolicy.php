<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Mail\Markdown;

class ReturnPolicy extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => 'Return Policy',
            'merchant_id' => $this->merchant_id,
            'content' => Markdown::parse($this->content)->toHtml(),
            'version' => $this->version,
        ];
    }
}
