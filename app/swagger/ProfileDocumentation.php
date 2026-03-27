<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;

class ProfileDocumentation {

    #[OA\Get(
        path: "/api/profile",
        summary: "Get the authenticated user's profile",
        tags: ["Profile"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "Authenticated user profile")
        ]
    )]
    public function show(){}

    #[OA\Put(
        path: "/api/profile",
        summary: "Update authenticated user's profile dietary tags",
        tags: ["Profile"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "dietary_tags", type: "array", items: new OA\Items(type: "string", example: "vegan"))
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Profile updated")
        ]
    )]
    public function update(){}
}