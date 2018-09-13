<?php
/**
 * Created by PhpStorm.
 * User: helio.junior
 * Date: 12/09/2018
 * Time: 09:38
 */

namespace App\GraphQL\Type;

use App\Post;
use App\User;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class PostType extends GraphQLType {

    protected $attributes = [
        'name' => 'Post',
        'description' => 'A post'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the post'
            ],
            'user' => [
                'type' => Type::getNullableType(GraphQL::type('User')),
                'description' => 'The user of this post'
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

    public function resolveUserField(Post $root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection(1);
        $query = User::query();

        $query->find(($root->user->id ?? 0));
        if ((isset($fields['posts_count']))) {
            $query->withCount('posts');
        }
        return $query->first()->toArray();
    }

}