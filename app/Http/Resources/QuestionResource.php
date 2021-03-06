<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class QuestionResource extends JsonResource
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
            'type'=>'question',
            'links'=>[
              'self'=>  url('/api/questions/'.$this->slug)
            ],
            'id'=>$this->id,
            'attributes'=>[
                'title'=>$this->title,
                'body'=>$this->body,
                'slug'=>$this->slug,
                'created_at'=>$this->created_at->diffForHumans()
            ],
            'counts'=>[
              'replies_count'=>$this->when(!is_null($this->replies_count), $this->replies_count),
                'likedusers_count'=>$this->likedusers()->count(),
            ],
            'relationships'=>[
                'author'=>new UserResource($this->user),
                'category'=>new CategoryResource($this->category),
                'replies'=>new ReplyCollection($this->whenLoaded('replies')),
                'likedusers'=>new UserCollection($this->whenLoaded('likedusers')),
                'islike'=>$this->likedusers()->where('user_id',Auth::user()->id)->exists()
            ]
        ];
    }
}
