<?php
/**
 * Created by PhpStorm.
 * User: helio.junior
 * Date: 13/09/2018
 * Time: 08:24
 */

namespace App\GraphQL\Mutation;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;
use App\Post;
use App\GraphQL\Type\PostType;


class CreateNewPostMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createNewPost'
    ];

    public function type()
    {
        return GraphQL::type('Post');
    }

    public function args()
    {
        $postType = new PostType();
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of author'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of post'
            ],
            'slug' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The slug of post'
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The content of post'
            ],
        ];
    }

    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'max:255', 'unique:posts'],
            'slug' => ['required', 'max:400', 'unique:posts'],
            'content' => ['required']
        ];
    }

    public function resolve($root, $args)
    {
        $post = new Post(collect($args)->only(['title', 'slug', 'content', 'user_id'])->toArray());
        $post->save();
        return $post;
    }
}