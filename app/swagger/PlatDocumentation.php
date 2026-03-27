<?php

namespace App\Swagger;
use OpenApi\Attributes as OA;

class PlatDocumentation {

    #[OA\Get(
        path: "/api/plates",
        summary: "List available plates",
        tags: ["Plates"],
        responses: [
            new OA\Response(response: 200, description: "List of plates")
        ]
    )]
    public function index(){}

    #[OA\Get(
        path: "/api/plates/{id}",
        summary: "Show plate details",
        tags: ["Plates"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Plate details")
        ]
    )]
    public function show(){}

    #[OA\Post(
        path: "/api/plates",
        summary: "Create a plate",
        tags: ["Plates"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name","price","category_id"],
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "price", type: "number"),
                    new OA\Property(property: "image", type: "string"),
                    new OA\Property(property: "is_available", type: "boolean"),
                    new OA\Property(property: "category_id", type: "integer"),
                    new OA\Property(property: "ingredient_ids", type: "array", items: new OA\Items(type: "integer"))
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Plate created")
        ]
    )]
    public function store(){}

    #[OA\Put(
        path: "/api/plates/{id}",
        summary: "Update a plate",
        tags: ["Plates"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "price", type: "number"),
                    new OA\Property(property: "image", type: "string"),
                    new OA\Property(property: "is_available", type: "boolean"),
                    new OA\Property(property: "category_id", type: "integer"),
                    new OA\Property(property: "ingredient_ids", type: "array", items: new OA\Items(type: "integer"))
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Plate updated")
        ]
    )]
    public function update(){}

    #[OA\Delete(
        path: "/api/plates/{id}",
        summary: "Delete a plate",
        tags: ["Plates"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Plate deleted")
        ]
    )]
    public function destroy(){}
}