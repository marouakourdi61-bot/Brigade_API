<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;

class CategoryDocumentation {
    #[OA\Get(
        path: "/api/categories",
        summary: "List active categories",
        tags: ["Categories"],
        responses: [
            new OA\Response(response: 200, description: "List of categories")
        ]
    )]
    public function index(){}

    #[OA\Post(
        path: "/api/categories",
        summary: "Create a category",
        tags: ["Categories"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "color", type: "string"),
                    new OA\Property(property: "is_active", type: "boolean")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Category created")
        ]
    )]
    public function store(){}

    #[OA\Get(
        path: "/api/categories/{id}",
        summary: "Show a category",
        tags: ["Categories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Category details")
        ]
    )]
    public function show(){}

    #[OA\Put(
        path: "/api/categories/{id}",
        summary: "Update a category",
        tags: ["Categories"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "color", type: "string"),
                    new OA\Property(property: "is_active", type: "boolean")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Category updated")
        ]
    )]
    public function update(){}

    #[OA\Delete(
        path: "/api/categories/{id}",
        summary: "Delete a category",
        tags: ["Categories"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Category deleted"),
            new OA\Response(response: 400, description: "Cannot delete category with plates")
        ]
    )]
    public function destroy(){}

    #[OA\Get(
        path: "/api/categories/{id}/plates",
        summary: "List plates by category",
        tags: ["Categories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "List of plates")
        ]
    )]
    public function showPlates(){}
}