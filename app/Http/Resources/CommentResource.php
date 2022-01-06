<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentResource extends ResourceCollection
{

    protected $comment;
    public function __construct($comment)
    {
        $this->comment=$comment;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
     public function toArray($request)
    {
        return [
            'id'=>$this->comment->id,
            'title'=>$this->comment->title,
            'ownername'=>$this->comment->user->name,
            'permission_to_delete'=> $this->comment->user->id === auth()->id(),
            'is_favourited'=> $this->comment->favourites()->where('user_id',auth()->id())->exists(),
            'favourites_count'=>$this->comment->favourites_count,
            'humantime'=>$this->comment->created_at->diffForHumans(),
            'created_at'=>$this->comment->created_at->format('d/m/y'),
            'threadid'=>$this->comment->thread->id,
            'path'=>$this->comment->thread->path(),
            'is_best'=>$this->comment->is_best
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
}
