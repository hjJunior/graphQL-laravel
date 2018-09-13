<?php
/**
 * Created by PhpStorm.
 * User: helio.junior
 * Date: 12/09/2018
 * Time: 09:43
 */

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\Post;


class PostsQuery extends Query {

    protected $attributes = [
        'name' => 'posts'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('Post'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'slug' => ['name' => 'slug', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $posts = Post::query();

        if (isset($args['id'])) {
            $posts->where('id' , $args['id']);
        }
        if(isset($args['email'])) {
            $posts->where('slug', $args['slug']);
        }
        return $posts->get();
    }

}