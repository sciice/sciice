<?php

namespace Sciice\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed username
 * @property mixed email
 * @property mixed mobile
 * @property mixed avatar
 * @property mixed roles
 * @property mixed state
 * @property mixed created_at
 * @property mixed updated_at
 * @method imageUrl(string $string)
 */
class SciiceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'username'   => $this->username,
            'email'      => $this->email,
            'mobile'     => $this->mobile,
            'avatar'     => $this->when($this->avatar, $this->imageUrl('avatar')),
            $this->mergeWhen($this->whenLoaded('roles'), [
                'role_id'   => optional($this->roles->first())->id,
                'role_name' => optional($this->roles->first())->title,
            ]),
            'state'      => $this->state,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
