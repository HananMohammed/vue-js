<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            "id" => $this->id,
            "title" => $this->title,
            "body" => $this->body,
        ];
    }

    public function with($request)
    {
        //https://medium.com/zero-equals-false/using-laravel-5-5-resources-to-create-your-own-json-api-formatted-api-2c6af5e4d0e8
        //https://jsonapi.org/
         return[
             "version" => "1.0.0",
             "author_url" => url("we-coders.com"),
         ];

    }
}
