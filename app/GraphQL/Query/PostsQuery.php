<?php
/**
 * Created by PhpStorm.
 * User: helio.junior
 * Date: 12/09/2018
 * Time: 09:43
 */

namespace App\GraphQL\Query;

use GraphQL;
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

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return Post::where('id' , $args['id'])->get();
        } else if(isset($args['email'])) {
            return Post::where('slug', $args['slug'])->get();
        } else {
            return Post::all();
        }
    }

}