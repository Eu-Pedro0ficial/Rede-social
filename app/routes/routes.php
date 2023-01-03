<?php

    return[
        "POST" => [
            "/login" => "Login@store",
            "/register" => "Register@create",
            "/posts" => "Posts@create",
            "/posts/updated" => "Posts@updated",
            "/user/update" => "User@updated"
        ],
        "GET" => [
            "/" => "Home@index",
            "/register" => "Register@index",
            "/logout" => "Login@destroy",
            "/posts/delete/[0-9]+" => "Posts@delete",
            "/posts/update/[0-9]+" => "Posts@update",
            "/profile" => "User@profile",
            "/user/update" => "User@update",
            "/user/delete" => "User@delete"
        ]
    ];