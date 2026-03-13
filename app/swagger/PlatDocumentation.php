<?php 
namespace App\Swagger;
use OpenApi\Attributes as OA;

class PlatDocumentation {

 #[OA\Get(
        path: "/api/plats",
        summary: "Get all plats",
        tags: ["Plats"],
        security: [["sanctum" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of plats"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function index(){}

    #[OA\Post(
        path: "/api/plats",
        summary: "Create a plat",
        tags: ["Plats"],
        security: [["sanctum" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name","price","category_id"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Pizza"),
                    new OA\Property(property: "description", type: "string", example: "Pizza fromage"),
                    new OA\Property(property: "price", type: "number", example: 80),
                    new OA\Property(property: "category_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Plat created"),
            new OA\Response(response: 422, description: "Validation error")
        ]
    )]
    public function store(){}


    #[OA\Get(
        path: "/api/plats/{id}",
        summary: "Get a plat",
        tags: ["Plats"],
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
            new OA\Response(response: 200, description: "Plat details"),
            new OA\Response(response: 404, description: "Plat not found")
        ]
    )]
    public function show(){}


    #[OA\Put(
        path: "/api/plats/{id}",
        summary: "Update a plat",
        tags: ["Plats"],
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
                required: ["name","price","category_id"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Pizza"),
                    new OA\Property(property: "description", type: "string", example: "Pizza fromage"),
                    new OA\Property(property: "price", type: "number", example: 90),
                    new OA\Property(property: "category_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Plat updated"),
            new OA\Response(response: 404, description: "Plat not found")
        ]
    )]
    public function update(){}



    #[OA\Delete(
        path: "/api/plats/{id}",
        summary: "Delete a plat",
        tags: ["Plats"],
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
            new OA\Response(response: 200, description: "Plat deleted"),
            new OA\Response(response: 404, description: "Plat not found")
        ]
    )]
    public function destroy(){}

    #[OA\Post(
        path: "/api/categories/{id}/plats",
        summary: "Create a plat in a category",
        tags: ["Categories","Plats"],
        security: [["sanctum" => []]],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "Category ID",
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name","price"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Burger"),
                    new OA\Property(property: "description", type: "string", example: "Burger viande"),
                    new OA\Property(property: "price", type: "number", example: 70)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Plat created in category"
            )
        ]
    )]
    public function storeByCategory() {}

    
}