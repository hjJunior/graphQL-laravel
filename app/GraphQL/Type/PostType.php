<?php
/**
 * Created by PhpStorm.
 * User: helio.junior
 * Date: 12/09/2018
 * Time: 09:38
 */

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

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
            'user_id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of user of this post'
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

}