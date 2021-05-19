<?php

namespace App\Http\Resources;

use App\Models\Reply;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ReplyResource extends JsonResource
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
            'type'=>'reply',
            'links'=>[
                'self'=>  url('/api/replies/'.$this->id)
            ],
            'id'=>$this->id,
            'attributes'=>[
                'body'=>$this->body,
            ],
            'relationships'=>[
                'islike'=>$this->likedusers()->exists(Auth::user()->id),
                'question'=>new QuestionResource($this->whenLoaded('question')),
                'user'=>new UserResource($this->user),
                'likedusers'=>new UserCollection($this->whenLoaded('likedusers'))
            ]
        ];
    }
}
