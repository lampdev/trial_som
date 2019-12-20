<?php

namespace App\Http\Resources\Folder;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class FolderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];

        if (!empty($this->resource)) {
            foreach($this->resource as $item) {
                $data[] = [
                    'title' => $item->title,
                    'parent_id' => $item->parent_id,
                    'id' => $item->id,
                    'user_id' => $item->user_id,
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d H:i')
                ];
            }
        }
        return $data;
    }
}
