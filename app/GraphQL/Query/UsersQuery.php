<?php
/**
 * Created by PhpStorm.
 * User: helio.junior
 * Date: 12/09/2018
 * Time: 08:29
 */

namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;
use App\User;

class UsersQuery extends Query {

    protected $attributes = [
        'name' => 'users'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('User'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::id()],
            'email' => ['name' => 'email', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $fields = $info->getFieldSelection($depth = 3);
        $users = User::query();

        foreach ($fields as $field => $keys) {
            if ($field === 'posts_count') {
                $users->withCount('posts');
            }
            if ($field === 'posts') {
                $users->with('posts');
            }
        }

        if (isset($args['id'])) {
            return $users->where('id' , $args['id'])->get();
        } else if(isset($args['email'])) {
            return $users->where('email', $args['email'])->get();
        }
        return $users->get();
    }

}