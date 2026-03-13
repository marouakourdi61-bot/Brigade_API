<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;
class CategoryDocumentation
{
    #[OA\Get(
        path: "/api/categories",
        summary: "Get all categories for authenticated user",
        tags: ["Categories"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of categories"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function index()
    {
    }



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
                    new OA\Property(property: "name", type: "string", example: "Desserts")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Category created"),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function store()
    {
    }



    #[OA\Get(
        path: "/api/categories/{id}",
        summary: "Get a category",
        tags: ["Categories"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Category details"),
            new OA\Response(response: 404, description: "Category not found")
        ]
    )]

    public function show(){}


    #[OA\Put(
        path: "/api/categories/{id}",
        summary: "Update a category",
        tags: ["Categories"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Plats principaux")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Category updated"),
            new OA\Response(response: 404, description: "Category not found")
        ]
    )]

     public function update(){}



     #[OA\Delete(
        path: "/api/categories/{id}",
        summary: "Delete a category",
        tags: ["Categories"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Category deleted"),
            new OA\Response(response: 404, description: "Category not found")
        ]
    )]
    public function destroy(){}
}