<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;

class IngredientDocumentation {

    #[OA\Get(
        path: "/api/ingredients",
        summary: "List all ingredients",
        tags: ["Ingredients"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(response: 200, description: "List of ingredients")
        ]
    )]
    public function index(){}

    #[OA\Post(
        path: "/api/ingredients",
        summary: "Create a new ingredient",
        tags: ["Ingredients"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "tags", type: "array", items: new OA\Items(type: "string", example: "contains_meat"))
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Ingredient created")
        ]
    )]
    public function store(){}

    #[OA\Put(
        path: "/api/ingredients/{id}",
        summary: "Update an ingredient",
        tags: ["Ingredients"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "tags", type: "array", items: new OA\Items(type: "string"))
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Ingredient updated")
        ]
    )]
    public function update(){}

    #[OA\Delete(
        path: "/api/ingredients/{id}",
        summary: "Delete an ingredient",
        tags: ["Ingredients"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Ingredient deleted")
        ]
    )]
    public function destroy(){}
}