<?php

namespace App\Http\Resources\Folder;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class FolderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @suppress PhanUndeclaredClassMethod
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];

        if ($this->resource) {
            $data = [
                'title' => $this->resource->title,
                'parent_id' => $this->resource->parent_id,
                'id' => $this->resource->id,
                'user_id' => $this->resource->user_id,
                'created_at' => Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $this->resource->created_at
                )->format('Y-m-d H:i')
            ];
        }

        return $data;
    }
}
