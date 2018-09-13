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
        return [
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
            'title' => ['required', 'max:255', 'unique:posts'],
            'slug' => ['required', 'max:400', 'unique:posts'],
            'content' => ['required']
        ];
    }

    public function resolve($root, $args)
    {
        $post = new Post(collect($args)->only(['title', 'slug', 'content'])->toArray());
        $post->user_id = auth('api')->id();
        $post->save();
        return $post;
    }

    public function authorize($root, $args) {
        return auth('api')->check();
    }
}