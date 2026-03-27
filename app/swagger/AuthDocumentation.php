<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;

class AuthDocumentation {
    #[OA\Post(
        path: "/api/register",
        summary: "Register a new user",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name","email","password","password_confirmation","role"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Maroua"),
                    new OA\Property(property: "email", type: "string", example: "maroua@email.com"),
                    new OA\Property(property: "password", type: "string", example: "123456"),
                    new OA\Property(property: "password_confirmation", type: "string", example: "123456"),
                    new OA\Property(property: "role", type: "string", example: "client")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "User registered successfully"),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function register(){}

    #[OA\Post(
        path: "/api/login",
        summary: "Login user",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email","password"],
                properties: [
                    new OA\Property(property: "email", type: "string", example: "maroua@email.com"),
                    new OA\Property(property: "password", type: "string", example: "123456")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "User logged in"),
            new OA\Response(response: 401, description: "Invalid credentials")
        ]
    )]
    public function login(){}

    #[OA\Post(
        path: "/api/logout",
        summary: "Logout user",
        tags: ["Auth"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "User logged out")
        ]
    )]
    public function logout(){}

    #[OA\Get(
        path: "/api/user",
        summary: "Get authenticated user",
        tags: ["Auth"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "Authenticated user"),
            new OA\Response(response: 401, description: "Unauthenticated")
        ]
    )]
    public function user(){}
}