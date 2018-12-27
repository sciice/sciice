<?php

namespace Sciice\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed parent
 * @property mixed name
 * @property mixed title
 * @property mixed grouping
 * @property mixed created_at
 * @property mixed updated_at
 */
class AuthorizeResource extends JsonResource
{
    public function toArray($request)
    {
        $arr = array_except(explode('.', $this->name), 0);

        return [
            'id'         => $this->id,
            'parent'     => $this->parent,
            'name'       => $this->name,
            'controller' => head($arr),
            'action'     => last($arr),
            'title'      => $this->title,
            'grouping'   => $this->grouping,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
